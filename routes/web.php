<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
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

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile');

/*
|--------------------------------------------------------------------------
| KELAS & PENDAFTARAN (SISWA)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/kelas', function (Request $request) {
        $userId = Auth::id(); 
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        // Cek status pendaftaran
        $kelasAktif = DB::table('pendaftaran')
            ->where('user_id', $userId)
            ->where('status', 'aktif')
            ->first();

        // Query program
        $query = DB::table('program_kursus');

        if ($kelasAktif) {
            $query->where('id', $kelasAktif->program_id);
            $isRegistered = true; 
        } else {
            $isRegistered = false;
        }

        // Terapkan Filter
        $programs = $query->when($search, function ($q) use ($search) {
                return $q->where('nama_program', 'like', "%{$search}%");
            })
            ->when($kategori, function ($q) use ($kategori) {
                return $q->where('tipe_kelas', $kategori);
            })
            ->get();

        return view('kelas', compact('programs', 'isRegistered')); 
    })->name('kelas');

    // Nampilin form konfirmasi pendaftaran
    Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'index']);
    
    // Proses pendaftaran dari Dropdown
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| AREA KHUSUS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // 1. Dashboard Admin
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');

        $totalSiswa = DB::table('users')->where('role', 'siswa')->count();
        $totalProgram = DB::table('program_kursus')->count();
        $totalPendaftar = DB::table('pendaftaran')->count();

        return view('admin.dashboard', compact('totalSiswa', 'totalProgram', 'totalPendaftar'));
    })->name('admin.dashboard');

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
            ->select('pendaftaran.*', 'program_kursus.nama_program')
            ->orderBy('pendaftaran.created_at', 'desc')
            ->first();

        return view('admin.siswa_detail', compact('siswa', 'pendaftaran'));
    });

    // PROSES UPDATE DATA SISWA OLEH ADMIN
    Route::put('/admin/siswa/{id}/update', [AuthController::class, 'updateSiswaByAdmin']);

    // 4. Program Kursus
    Route::get('/admin/program', function () {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        $programs = DB::table('program_kursus')->orderBy('id', 'asc')->get();
        return view('admin.program', compact('programs'));
    });

    // 5. Tagihan & Bukti Pembayaran
    Route::get('/admin/tagihan', function () {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        $tagihans = DB::table('tagihan')
            ->join('pendaftaran', 'tagihan.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->select(
                'tagihan.id', 
                'users.name as nama_siswa', 
                'program_kursus.nama_program', 
                'tagihan.jumlah', 
                'tagihan.status', 
                'tagihan.created_at'
            )
            ->orderBy('tagihan.created_at', 'desc')
            ->get();

        return view('admin.tagihan', compact('tagihans'));
    });

    // 6. Proses Konfirmasi Pembayaran
    Route::post('/admin/tagihan/{id}/konfirmasi', function ($id) {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        DB::table('tagihan')->where('id', $id)->update([
            'status' => 'lunas',
            'updated_at' => now()
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi! Status tagihan sekarang Lunas.');
    });
});

/*
|--------------------------------------------------------------------------
| AREA KHUSUS INSTRUKTUR
|--------------------------------------------------------------------------
*/
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