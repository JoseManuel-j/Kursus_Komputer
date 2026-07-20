<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // Nampilin form
    public function index(int $id)
    {
        // Ambil SEMUA kelas buat ngisi dropdown
        $semuaProgram = DB::table('program_kursus')->orderBy('nama_program', 'asc')->get();

        // Simpan ID kelas yang tadi diklik buat dijadiin pilihan default
        $programTerpilih = $id;

        return view('registrasi', compact('semuaProgram', 'programTerpilih'));
    }

    // Proses simpan
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'program_id' => 'required',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'file_ijazah' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'file_ktp' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'pas_foto' => 'required|image|max:2048',
            'tipe_pembayaran' => 'required|in:lunas,angsuran',
            'bukti_bayar' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $program = DB::table('program_kursus')->where('id', $request->program_id)->first();
        $biayaPendaftaran = 100000;

        // Cicilan (angsuran) cuma boleh buat Program Paket. Program Satuan
        // wajib bayar lunas. Dicek di sini juga (bukan cuma di JS) supaya
        // nggak bisa diakalin lewat request manual/Postman.
        if ($request->tipe_pembayaran == 'angsuran' && ($program->kategori ?? 'satuan') !== 'paket') {
            return back()
                ->withErrors(['tipe_pembayaran' => 'Cicilan hanya tersedia untuk Program Paket. Program Satuan wajib dibayar lunas.'])
                ->withInput();
        }

        // FIX: cast ke (int) karena kolom 'biaya' di database bertipe decimal,
        // sehingga $program->biaya dikembalikan sebagai string desimal (mis. "2500000.00").
        // Kalau tidak di-cast, $totalTagihan akan jadi float, sedangkan $totalCicilan
        // (dari input cicilan yang sudah dibersihkan) adalah int murni.
        // Perbandingan strict (!==) antara int dan float SELALU dianggap tidak sama,
        // meskipun nilainya identik -> makanya validasi selalu gagal walau sudah pas.
        $totalTagihan = (int) $program->biaya + $biayaPendaftaran;

        // Validasi khusus cicilan (belum butuh file, jadi aman di awal)
        if ($request->tipe_pembayaran == 'angsuran') {
            if (!$request->filled('cicilan') || count(array_filter($request->cicilan)) === 0) {
                return back()->withErrors(['cicilan' => 'Nominal cicilan wajib diisi.'])->withInput();
            }

            $totalCicilan = 0;
            foreach ($request->cicilan as $nominal) {
                $angkaMurni = (int) str_replace('.', '', $nominal);
                $totalCicilan += $angkaMurni;
            }

            if ($totalCicilan !== $totalTagihan) {
                return back()->withErrors([
                    'cicilan' => 'Total cicilan (Rp ' . number_format($totalCicilan, 0, ',', '.') .
                                 ') harus sama persis dengan total tagihan (Rp ' .
                                 number_format($totalTagihan, 0, ',', '.') . '). Tidak boleh kurang atau lebih.'
                ])->withInput();
            }
        }

        // 2. Upload Dokumen Siswa
        $folderDokumen = public_path('uploads/dokumen_siswa');
        $namaKtp = time() . '_ktp_' . $request->file('file_ktp')->getClientOriginalName();
        $request->file('file_ktp')->move($folderDokumen, $namaKtp);

        $namaIjazah = time() . '_ijazah_' . $request->file('file_ijazah')->getClientOriginalName();
        $request->file('file_ijazah')->move($folderDokumen, $namaIjazah);

        $namaFoto = time() . '_foto_' . $request->file('pas_foto')->getClientOriginalName();
        $request->file('pas_foto')->move($folderDokumen, $namaFoto);

        // 3. Upload Bukti Bayar -> $namaFile didefinisikan DI SINI, sebelum dipakai di bawah
        $fileBukti = $request->file('bukti_bayar');
        $namaFile = time() . '_' . $fileBukti->getClientOriginalName();
        $fileBukti->move(public_path('uploads/bukti_pembayaran'), $namaFile);

        // 4. Simpan Pendaftaran -> $pendaftaranId didefinisikan DI SINI, sebelum dipakai di bawah
        $pendaftaranId = DB::table('pendaftaran')->insertGetId([
            'user_id' => Auth::id(),
            'program_id' => $request->program_id,
            'tanggal_daftar' => now(),
            'status' => 'aktif',
            'file_ktp' => $namaKtp,
            'file_ijazah' => $namaIjazah,
            'pas_foto' => $namaFoto,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Logika Pembayaran (Satu pintu) -> paling bawah, setelah $namaFile & $pendaftaranId ada
        if ($request->tipe_pembayaran == 'angsuran') {
            foreach ($request->cicilan as $index => $nominal) {
                $angkaMurni = str_replace('.', '', $nominal);
                if (!empty($angkaMurni) && $angkaMurni > 0) {
                    $isPertama = $index === 0;

                    DB::table('tagihan')->insert([
                        'pendaftaran_id' => $pendaftaranId,
                        'jumlah'         => $angkaMurni,
                        // cicilan ke-1: sudah ada bukti -> nunggu verifikasi admin
                        // cicilan ke-2 & 3: belum dibayar -> tetap 'cicilan' (slot terjadwal)
                        'status'         => $isPertama ? 'pending' : 'cicilan',
                        'jatuh_tempo'    => now()->addDays(30 * ($index + 1)),
                        // hanya cicilan ke-1 yang punya file, sisanya null
                        'buktiTransfer'  => $isPertama ? $namaFile : null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }
        } else {
            // Jika Lunas
            DB::table('tagihan')->insert([
                'pendaftaran_id' => $pendaftaranId,
                'jumlah' => $program->biaya,
                'status' => 'pending', // tetap pending dulu -> nunggu admin verifikasi buktinya
                'jatuh_tempo' => now(),
                'buktiTransfer' => $namaFile,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/dashboard')->with('success', 'Pendaftaran berhasil!');
    }
}