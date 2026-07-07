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
        // 1. Validasi input, pastiin semua berkas beneran gambar/PDF dan maksimal 2MB
        $request->validate([
            'program_id' => 'required',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'file_ktp' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'file_ijazah' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_bayar' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ], [
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'file_ktp.required' => 'FC KTP wajib diupload (JPG/PNG/PDF, maks 2MB).',
            'file_ktp.mimes' => 'Format FC KTP harus JPG, PNG, atau PDF.',
            'file_ijazah.required' => 'File Ijazah wajib diupload (JPG/PNG/PDF, maks 2MB).',
            'file_ijazah.mimes' => 'Format File Ijazah harus JPG, PNG, atau PDF.',
            'pas_foto.required' => 'Pas Foto 3x4 wajib diupload (JPG/PNG, maks 2MB).',
            'pas_foto.image' => 'Pas Foto harus berupa gambar (JPG/PNG).',
            'bukti_bayar.required' => 'Bukti pembayaran wajib diupload (JPG/PNG/PDF, maks 2MB).',
            'bukti_bayar.file' => 'Bukti pembayaran harus berupa file yang valid.',
            'bukti_bayar.mimes' => 'Format file bukti pembayaran harus JPG, PNG, atau PDF.',
            'bukti_bayar.max' => 'Ukuran file bukti pembayaran maksimal 2MB.',
        ]);

        // 2. Update data diri siswa di tabel users (tempat/tanggal lahir, agama, no hp, alamat)
        DB::table('users')->where('id', Auth::id())->update([
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'agama' => $request->input('agama'),
            'nomor_hp' => $request->input('no_hp'),
            'alamat' => $request->input('alamat'),
            'updated_at' => now(),
        ]);

        // Tangkap ID program dari dropdown form
        $programId = $request->input('program_id');
        $program = DB::table('program_kursus')->where('id', $programId)->first();

        // 2. Proses upload dokumen siswa (KTP, Ijazah, Pas Foto) ke folder public/uploads/dokumen_siswa
        $folderDokumen = public_path('uploads/dokumen_siswa');

        $fileKtp = $request->file('file_ktp');
        $namaKtp = time() . '_ktp_' . $fileKtp->getClientOriginalName();
        $fileKtp->move($folderDokumen, $namaKtp);

        $fileIjazah = $request->file('file_ijazah');
        $namaIjazah = time() . '_ijazah_' . $fileIjazah->getClientOriginalName();
        $fileIjazah->move($folderDokumen, $namaIjazah);

        $fotoSiswa = $request->file('pas_foto');
        $namaFoto = time() . '_foto_' . $fotoSiswa->getClientOriginalName();
        $fotoSiswa->move($folderDokumen, $namaFoto);

        // 3. Simpan ke tabel pendaftaran (sekalian nama file dokumen di atas)
        $pendaftaranId = DB::table('pendaftaran')->insertGetId([
            'user_id' => Auth::id(),
            'program_id' => $programId,
            'tanggal_daftar' => now(),
            'status' => 'aktif',
            'file_ktp' => $namaKtp,
            'file_ijazah' => $namaIjazah,
            'pas_foto' => $namaFoto,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Proses upload file bukti pembayaran
        $file = $request->file('bukti_bayar');
        // Bikin nama unik pakai timestamp biar nggak ketimpa kalau nama gambarnya sama
        $namaFile = time() . '_' . $file->getClientOriginalName();
        // Simpan fisik gambarnya ke folder public/uploads/bukti_pembayaran
        $file->move(public_path('uploads/bukti_pembayaran'), $namaFile);

        // 4. Buat tagihan sekalian nyimpen nama file gambar struknya
        DB::table('tagihan')->insert([
            'pendaftaran_id' => $pendaftaranId,
            'jumlah' => $program->biaya,
            'jatuh_tempo' => now()->addDays(7), 
            'status' => 'belum_lunas',
            'buktiTransfer' => $namaFile, // <-- Menyimpan nama file ke database
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/dashboard')->with('success', 'Berhasil mendaftar kelas ' . $program->nama_program . ' dan bukti bayar telah terkirim!');
    }
}