<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminProgramController;
use App\Http\Controllers\TagihanController;

// ===== TAMBAHAN CONTROLLER BARU UNTUK FITUR JADWAL =====
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\SiswaDashboardController;
// =======================================================

Route::get('/', function () {
    return view('home');
});

Route::get('/program', function () {
    return view('program-kursus');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 

// MENAMPILKAN HALAMAN FORM LUPA PASSWORD (TAMBAHAN)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

// PROSES VERIFIKASI EMAIL (TAMBAHAN)
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

/*
|--------------------------------------------------------------------------
| DASHBOARD & PROFILE SISWA
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// ===== TAMBAHAN ROUTE UNTUK DASHBOARD JADWAL SISWA =====
Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])->middleware('auth')->name('siswa.dashboard');
// =======================================================

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile');

// ===== ROUTE ANGSURAN — DIPERBAIKI SUPAYA MENAMPILKAN SEMUA KELAS SISWA =====
// Sebelumnya route ini cuma ->first() (ambil 1 pendaftaran), padahal 1 siswa
// bisa punya banyak pendaftaran/kelas. Sekarang semua kelas ditarik lalu
// masing-masing dihitung tagihan & sisa bayarnya sendiri-sendiri.
Route::get('/angsuran', function () {
    $userId = Auth::id();

    // Ambil SEMUA pendaftaran milik siswa ini (bukan cuma satu)
    $semuaPendaftaran = DB::table('pendaftaran')
        ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
        ->where('pendaftaran.user_id', $userId)
        ->select('pendaftaran.*', 'program_kursus.nama_program', 'program_kursus.biaya as total_biaya')
        ->orderBy('pendaftaran.created_at', 'desc')
        ->get();

    // Untuk tiap kelas, hitung riwayat tagihan + sisa bayar + status lunas
    // dengan rumus YANG SAMA persis seperti di admin/tagihan dan admin/dashboard,
    // supaya tidak ada lagi angka yang beda-beda antar halaman.
    $kelasList = $semuaPendaftaran->map(function ($p) {
        $tagihans = DB::table('tagihan')
            ->where('pendaftaran_id', $p->id)
            ->orderBy('id', 'asc')
            ->get();

        $totalMasuk = $tagihans
            ->where('status',  'lunas')
            ->sum('jumlah');

        $sisaBayar = ($p->total_biaya ?? 0) - $totalMasuk;
        $statusLunas = $sisaBayar <= 0 ? 'Lunas' : 'Belum Lunas';
        $nextTagihan = $tagihans->firstWhere('status', 'cicilan');


        return (object) [
            'pendaftaran'  => $p,
            'tagihans'     => $tagihans,
            'totalMasuk'   => $totalMasuk,
            'sisaBayar'    => max(0, $sisaBayar),
            'statusLunas'  => $statusLunas,
            'nextTagihan'  => $nextTagihan,
        ];
    });

    return view('angsuran', compact('kelasList'));
})->middleware('auth')->name('angsuran');

// --- Rute untuk Siswa Upload Bukti Bayar ---
Route::post('/angsuran/bayar', function (Request $request) {
    // 1. Validasi input
    $request->validate([
        'pendaftaran_id' => 'required|exists:pendaftaran,id',
        'jumlah'         => 'required|numeric|min:1',
        'bukti_bayar'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]); 

      return DB::transaction(function () use ($request) {
        // Ambil baris cicilan PALING AWAL yang belum dibayar, kunci baris ini
        // supaya aman dari double-klik / race condition
        $tagihan = DB::table('tagihan')
            ->where('pendaftaran_id', $request->pendaftaran_id)
            ->where('status', 'cicilan')
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->first();

        if (!$tagihan) {
            return back()->with('error', 'Tidak ada angsuran yang perlu dibayar. Mungkin sudah lunas semua atau sedang diverifikasi admin.');
        }

    // 2. Proses upload file
    $file = $request->file('bukti_bayar');
    $namaFile = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('uploads/bukti_pembayaran'), $namaFile);

    // 3. Simpan ke database dengan status 'pending'
    DB::table('tagihan')->insert([
        'pendaftaran_id' => $request->pendaftaran_id,
        'jumlah'         => $request->jumlah,
        'status'         => 'pending',
        'buktiTransfer'  => $namaFile,
        'tanggal_bayar'  => now(),
        'jatuh_tempo'    => now(),
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return back()->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi Admin.');
      });
})->middleware('auth')->name('siswa.angsuran.bayar');
// ============================================================================

/*
|--------------------------------------------------------------------------
| KELAS & PENDAFTARAN (SISWA)
|--------------------------------------------------------------------------
*/

Route::get('/kelas', function (Request $request) {
        $userId = Auth::id();
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        // 1. Ambil SEMUA pendaftaran aktif milik siswa ini (bukan cuma satu)
        // FIX: sebelumnya pakai ->first() sehingga hanya 1 kelas yang kebawa
        // walau siswa punya beberapa pendaftaran berstatus 'aktif' sekaligus.
        $kelasAktif = DB::table('pendaftaran')
            ->where('user_id', $userId)
            ->where('status', 'aktif')
            ->get();

        // Kumpulan program_id yang sudah didaftar siswa ini
        $registeredProgramIds = $kelasAktif->pluck('program_id')->toArray();

        // 2. Tarik SEMUA program dari database dengan fitur pencarian
        $semuaProgram = DB::table('program_kursus')
            ->when($search, function ($q) use ($search) {
                return $q->where('nama_program', 'like', "%{$search}%");
            })
            ->when($kategori, function ($q) use ($kategori) {
                return $q->where('tipe_kelas', $kategori);
            })
            ->get();

        // 3. Pisahkan data menjadi 2 kelompok (Yang sudah didaftar vs Belum didaftar)
        // FIX: $programTerdaftar sekarang COLLECTION (bisa berisi banyak kelas),
        // bukan objek tunggal seperti sebelumnya.
        $programTerdaftar = $semuaProgram->whereIn('id', $registeredProgramIds)->values();
        $programLainnya = $semuaProgram->whereNotIn('id', $registeredProgramIds)->values();

        return view('kelas', compact('programTerdaftar', 'programLainnya', 'kelasAktif'));
    })->name('kelas');

    // Nampilin form konfirmasi pendaftaran
    Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'index']);
    
    // Proses pendaftaran dari Dropdown
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']);


/* AREA KHUSUS ADMIN */

Route::middleware('auth')->group(function () {
    
// 1. Dashboard Admin
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');

        $totalSiswa = DB::table('users')->where('role', 'siswa')->count();
        $totalProgram = DB::table('program_kursus')->count();
        $totalPendaftar = DB::table('pendaftaran')->count();

        // UBAH MENJADI leftJoin agar baris data tidak hilang jika ada data dummy yang mismatch
        // FIX: tambahkan ->limit(5) supaya judul "5 Pendaftaran Terbaru" benar-benar
        // menampilkan 5 data, bukan seluruh data pendaftaran.
        $pendaftaran = DB::table('pendaftaran')
            ->leftJoin('users', 'pendaftaran.user_id', '=', 'users.id')
            ->leftJoin('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->select(
                'pendaftaran.*', 
                'users.name as nama_siswa', 
                'program_kursus.nama_program',
                'program_kursus.biaya as total_biaya_kelas'
            )
            ->orderBy('pendaftaran.created_at', 'desc')
            ->limit(5)
            ->get();

        // LOGIKA PERHITUNGAN SISA BAYAR & PENGAMBILAN JADWAL
        foreach ($pendaftaran as $item) {
            // Hitung sisa bayar (cicilan + lunas dihitung sebagai uang masuk)
            $totalMasuk = DB::table('tagihan')
                ->where('pendaftaran_id', $item->id)
                ->where('status' , 'lunas')
                ->sum('jumlah');

            $item->sisa_bayar = ($item->total_biaya_kelas ?? 0) - $totalMasuk;

            // Ambil data jadwal
            $item->jadwal = DB::table('jadwal_kelas')
                ->where('pendaftaran_id', $item->id)
                ->get();
        }

        

        return view('admin.dashboard', compact('totalSiswa', 'totalProgram', 'totalPendaftar', 'pendaftaran'));
    })->name('admin.dashboard');

    // Update Status Pembayaran Manual via Dropdown (dengan validasi sisa bayar)
Route::post('/admin/tagihan/simpan', function (Request $request) {
    if (Auth::user()->role !== 'admin') return redirect('/dashboard');

    $validated = $request->validate([
        'pendaftaran_id' => 'required|exists:pendaftaran,id',
        'jumlah'         => 'required|numeric|min:1',
        'status'         => 'required|in:pending,cicilan,lunas',
    ]);

    // Ambil total biaya program
    $pendaftaran = DB::table('pendaftaran')
        ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
        ->where('pendaftaran.id', $validated['pendaftaran_id'])
        ->select('program_kursus.biaya as total_biaya')
        ->first();

    $totalBiaya = $pendaftaran->total_biaya ?? 0;

    // Hitung uang masuk (Lunas)
    $totalMasuk = DB::table('tagihan')
        ->where('pendaftaran_id', $validated['pendaftaran_id'])
        ->where('status', 'lunas')
        ->sum('jumlah');

    $sisaBayar = $pendaftaran->total_biaya - $totalMasuk;

    if ($validated['jumlah'] > $sisaBayar) {
        return back()->withErrors(['jumlah' => 'Nominal melebihi sisa bayar. Sisa: Rp ' . number_format($sisaBayar, 0, ',', '.')])->withInput();
    }

    DB::table('tagihan')->insert([
        'pendaftaran_id' => $validated['pendaftaran_id'],
        'jumlah'         => $validated['jumlah'],
        'status'         => $validated['status'],
        'tanggal_bayar'  => now(),
        'jatuh_tempo'    => now(),
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return back()->with('success', 'Pembayaran berhasil ditambahkan!');
})->name('admin.tagihan.simpan');


    // 2. Data Siswa
    Route::get('/admin/siswa', function () {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        $siswas = DB::table('users')->where('role', 'siswa')->orderBy('created_at', 'desc')->get();
        return view('admin.siswa', compact('siswas'));
    });

    // 3. Detail siswa
    Route::get('/admin/siswa/{id}', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        $siswa = DB::table('users')->where('id', $id)->where('role', 'siswa')->first();

        if (!$siswa) {
            return redirect('/admin/siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        $pendaftaran = DB::table('pendaftaran')
            ->leftJoin('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->where('pendaftaran.user_id', $id)
            ->select('pendaftaran.*', 'program_kursus.nama_program', 'program_kursus.biaya as total_biaya')
            ->orderBy('pendaftaran.created_at', 'desc')
            ->first();

        // Tarik data angsuran khusus untuk pendaftaran siswa ini
        $tagihans = [];
        if ($pendaftaran) {
            $tagihans = DB::table('tagihan')
                ->where('pendaftaran_id', $pendaftaran->id)
                ->orderBy('id', 'asc') // Urutkan dari angsuran pertama ke terakhir
                ->get();
        }

        return view('admin.siswa_detail', compact('siswa', 'pendaftaran', 'tagihans'));
    });
    // PROSES UPDATE DATA SISWA OLEH ADMIN
    Route::put('/admin/siswa/{id}/update', [AuthController::class, 'updateSiswaByAdmin']);

    // 4. Program Kursus
    Route::get('/admin/program', [AdminProgramController::class, 'index'])
        ->name('admin.program');

    Route::get('/admin/program/tambah', [AdminProgramController::class, 'create'])
        ->name('admin.program.create');

    Route::post('/admin/program/simpan', [AdminProgramController::class, 'store'])
        ->name('admin.program.store');

    Route::get('/admin/program/{id}/edit', [AdminProgramController::class, 'edit'])
        ->name('admin.program.edit');

    Route::put('/admin/program/{id}', [AdminProgramController::class, 'update'])
        ->name('admin.program.update');

    //  TAMBAHAN ROUTE UNTUK SIMPAN JADWAL DARI HALAMAN EDIT PROGRAM =====
    Route::post('/admin/jadwal/simpan', [JadwalController::class, 'store'])
        ->name('admin.jadwal.store');

        // Buka halaman kelola jadwal
    Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal.index');
    // ========================================================================

// 5. Tagihan & Bukti Pembayaran

    // 8. Tambah Pembayaran / Cicilan Manual oleh Admin
    // Tanpa upload bukti transfer (admin yang input langsung dari cash/transaksi
    // yang sudah diverifikasi sendiri) + validasi nominal tidak melebihi sisa bayar
// Pastikan kode ini ADA di dalam routes/web.php Anda
Route::post('/admin/tagihan/simpan', function (Request $request) {
    if (Auth::user()->role !== 'admin') return redirect('/dashboard');

    $validated = $request->validate([
        'pendaftaran_id' => 'required|exists:pendaftaran,id',
        'jumlah'         => 'required|numeric|min:1',
        'status'         => 'required|in:pending,cicilan,lunas',
    ]);

    // Ambil total biaya program dari pendaftaran yang dipilih
    $pendaftaran = DB::table('pendaftaran')
        ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
        ->where('pendaftaran.id', $validated['pendaftaran_id'])
        ->select('program_kursus.biaya as total_biaya')
        ->first();

    $totalBiaya = $pendaftaran->total_biaya ?? 0;

    // Hitung uang masuk (HANYA yang statusnya 'lunas')
    $totalMasuk = DB::table('tagihan')
        ->where('pendaftaran_id', $validated['pendaftaran_id'])
        ->where('status', 'lunas')
        ->sum('jumlah');

    $sisaBayar = $totalBiaya - $totalMasuk;

    // Validasi: nominal baru tidak boleh melebihi sisa bayar
    if ($validated['jumlah'] > $sisaBayar) {
        return back()
            ->withErrors(['jumlah' => 'Nominal melebihi sisa bayar. Sisa: Rp ' . number_format($sisaBayar, 0, ',', '.')])
            ->withInput();
    }

    DB::table('tagihan')->insert([
        'pendaftaran_id' => $validated['pendaftaran_id'],
        'jumlah'         => $validated['jumlah'],
        'status'         => $validated['status'],
        'tanggal_bayar'  => now(),
        'jatuh_tempo'    => now(),
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return back()->with('success', 'Pembayaran berhasil ditambahkan!');
})->name('admin.tagihan.simpan'); // <--- Bagian ini yang dicari oleh Laravel

        return back()->with('success', 'Pembayaran berhasil ditambahkan!');
    })->name('admin.tagihan.simpan');

    Route::get('/admin/tagihan', function () {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        // Mulai dari Pendaftaran agar semua pendaftar muncul
        // FIX: tambahkan tagihan.created_at & tagihan.updated_at ke select supaya
        // kolom "Tanggal Bayar" di halaman Tagihan & Bukti bisa ditampilkan
        // (sebelumnya 2 kolom ini tidak ditarik sama sekali dari database).
        $tagihans = DB::table('pendaftaran')
            ->leftJoin('tagihan', 'pendaftaran.id', '=', 'tagihan.pendaftaran_id')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->select(
                'pendaftaran.id as pendaftaran_id', 
                'tagihan.id', 
                'tagihan.jumlah', 
                'tagihan.status', 
                'tagihan.buktiTransfer',
                'tagihan.created_at as tagihan_created_at',
                'tagihan.updated_at as tagihan_updated_at',
                'users.name as nama_siswa', 
                'program_kursus.nama_program', 
                'program_kursus.biaya as total_biaya_kelas'
            )
            ->orderBy('pendaftaran.created_at', 'desc')
            ->get();

        // Hitung sisa bayar (cicilan + lunas dihitung sebagai uang masuk,
        // pending/ditolak tidak dihitung karena belum terverifikasi/gagal)
        foreach ($tagihans as $t) {
            $totalMasuk = DB::table('tagihan')
                ->where('pendaftaran_id', $t->pendaftaran_id)
                ->where('status', 'lunas')
                ->sum('jumlah');
                
            $t->sisa_bayar = ($t->total_biaya_kelas ?? 0) - $totalMasuk;
        }

        return view('admin.tagihan', compact('tagihans'));
    })->name('admin.tagihan');

    // 6. Proses Konfirmasi Pembayaran
    Route::post('/admin/tagihan/{id}/konfirmasi', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        DB::table('tagihan')->where('id', $id)->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi! Status tagihan sekarang Lunas.');
    });

    // 7. Proses Tolak Bukti Pembayaran
    Route::post('/admin/tagihan/{id}/tolak', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        DB::table('tagihan')->where('id', $id)->update([
            'status' => 'ditolak',
            'updated_at' => now()
        ]);

        return back()->with('success', 'Bukti pembayaran ditolak. Silakan hubungi siswa untuk upload ulang.');
    });

/* AREA KHUSUS INSTRUKTUR */
Route::middleware('auth')->group(function () {
    Route::get('/instruktur/jadwal', function () {
        if (Auth::user()->role !== 'instruktur') {
            return redirect('/dashboard');
        }
        
        $jadwals = DB::table('jadwal_kelas')
            ->join('program_kursus', 'jadwal_kelas.program_id', '=', 'program_kursus.id')
            ->where('jadwal_kelas.instruktur_id', Auth::id())
            ->select('jadwal_kelas.*', 'program_kursus.nama_program')
            ->get();
        
        return view('instruktur.jadwal', compact('jadwals'));
    });
});