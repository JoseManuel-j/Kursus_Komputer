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
        // 1. Validasi input, pastiin file bukti_bayar beneran gambar dan maksimal 2MB
        $request->validate([
            'program_id' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Tangkap ID program dari dropdown form
        $programId = $request->input('program_id');
        $program = DB::table('program_kursus')->where('id', $programId)->first();

        // 2. Simpan ke tabel pendaftaran
        $pendaftaranId = DB::table('pendaftaran')->insertGetId([
            'user_id' => Auth::id(),
            'program_id' => $programId,
            'tanggal_daftar' => now(),
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Proses upload file bukti pembayaran
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