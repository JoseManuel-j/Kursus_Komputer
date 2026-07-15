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
        // ... (validasi lainnya tetap sama)
        'bukti_bayar' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
    ]);

    // 2. Upload Dokumen Siswa
    $folderDokumen = public_path('uploads/dokumen_siswa');
    $namaKtp = time() . '_ktp_' . $request->file('file_ktp')->getClientOriginalName();
    $request->file('file_ktp')->move($folderDokumen, $namaKtp);
    
    $namaIjazah = time() . '_ijazah_' . $request->file('file_ijazah')->getClientOriginalName();
    $request->file('file_ijazah')->move($folderDokumen, $namaIjazah);
    
    $namaFoto = time() . '_foto_' . $request->file('pas_foto')->getClientOriginalName();
    $request->file('pas_foto')->move($folderDokumen, $namaFoto);

    // 3. Upload Bukti Bayar (DILAKUKAN DI AWAL agar variabel $namaFile siap dipakai)
    $fileBukti = $request->file('bukti_bayar');
    $namaFile = time() . '_' . $fileBukti->getClientOriginalName();
    $fileBukti->move(public_path('uploads/bukti_pembayaran'), $namaFile);

    // 4. Simpan Pendaftaran
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

    // 5. Logika Pembayaran (Satu pintu)
    if ($request->tipe_pembayaran == 'angsuran') {
        foreach ($request->cicilan as $nominal) {
            $angkaMurni = str_replace('.', '', $nominal); 
            if (!empty($angkaMurni) && $angkaMurni > 0) {
                DB::table('tagihan')->insert([
                    'pendaftaran_id' => $pendaftaranId,
                    'jumlah' => $angkaMurni,
                    'status' => 'cicilan',
                    'jatuh_tempo' => now()->addDays(30),
                    'buktiTransfer' => $namaFile,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    } else {
        // Jika Lunas
        $program = DB::table('program_kursus')->where('id', $request->program_id)->first();
        DB::table('tagihan')->insert([
            'pendaftaran_id' => $pendaftaranId,
            'jumlah' => $program->biaya,
            'status' => 'lunas',
            'jatuh_tempo' => now(),
            'buktiTransfer' => $namaFile,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect('/dashboard')->with('success', 'Pendaftaran berhasil!');

    }
}