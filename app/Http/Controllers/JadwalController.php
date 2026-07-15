<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        // 1. Ambil data jadwal untuk tabel di sebelah kanan
        // Kita join ke pendaftaran, users, dan program biar tahu ini jadwal punya siapa
        $jadwals = DB::table('jadwal_kelas')
            ->join('pendaftaran', 'jadwal_kelas.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->select('jadwal_kelas.*', 'users.name as nama_siswa', 'program_kursus.nama_program')
            ->orderBy('jadwal_kelas.created_at', 'desc')
            ->get();

        // 2. Ambil data murid yang SUDAH LUNAS untuk pilihan di dropdown form
        $muridLunas = DB::table('pendaftaran')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->join('tagihan', 'tagihan.pendaftaran_id', '=', 'pendaftaran.id')
            ->where('tagihan.status', 'lunas') // WAJIB LUNAS
            ->select('pendaftaran.id as pendaftaran_id', 'users.name as nama_siswa', 'program_kursus.nama_program')
            ->get();

        return view('admin.jadwal', compact('jadwals', 'muridLunas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required', // Sekarang pakai pendaftaran_id
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        DB::table('jadwal_kelas')->insert([
            'pendaftaran_id' => $request->pendaftaran_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $request->ruangan ?? '-',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Jadwal berhasil diatur untuk murid tersebut!');
    }
}