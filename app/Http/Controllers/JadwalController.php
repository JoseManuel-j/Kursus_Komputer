<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        // 1. Ambil data jadwal
        $jadwals = DB::table('jadwal_kelas')
            ->join('pendaftaran', 'jadwal_kelas.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->select('jadwal_kelas.*', 'users.name as nama_siswa', 'program_kursus.nama_program')
            ->orderBy('jadwal_kelas.created_at', 'desc')
            ->get();

        // 2. AMBIL MURID YANG BOLEH DIJADWALIN
        $muridLunas = DB::table('pendaftaran')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->whereIn('pendaftaran.id', function($query) {
                // Logika: Ambil pendaftaran yang MINIMAL punya 1 tagihan Lunas / Verifikasi Admin
                $query->select('pendaftaran_id')
                      ->from('tagihan')
                      ->whereIn('status', ['Lunas', 'Verifikasi Admin']);
            })
            ->select('pendaftaran.id as pendaftaran_id', 'users.name as nama_siswa', 'program_kursus.nama_program')
            ->distinct()
            ->get();

        return view('admin.jadwal', compact('jadwals', 'muridLunas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required',
            'hari'           => 'required|string',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
        ]);

        DB::table('jadwal_kelas')->insert([
            'pendaftaran_id' => $request->pendaftaran_id,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => $request->ruangan ?? '-',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal berhasil diatur untuk murid tersebut!');
    }
}