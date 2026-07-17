<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    // Fungsi untuk menampilkan halaman admin tagihan
    public function index()
    {
        $tagihans = DB::table('tagihan')
            ->join('pendaftaran', 'tagihan.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->select(
                'tagihan.*', 
                'users.name as nama_siswa', 
                'program_kursus.nama_program',
                'tagihan.updated_at as tagihan_updated_at'
            )
            ->get();

        return view('admin.tagihan', compact('tagihans'));
    }

    // Fungsi untuk memperbarui status (Dipanggil saat tombol Simpan diklik)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        DB::table('tagihan')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now() 
        ]);

        return back()->with('success', 'Status tagihan berhasil diperbarui!');
    }
}