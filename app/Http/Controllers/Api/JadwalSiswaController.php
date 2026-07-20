<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalSiswaController extends Controller
{
    // GET /api/siswa/jadwal — Rancangan Endpoint Jadwal Kelas (3.5.1.16)
    // Nampilin jadwal kelas dari semua program yang lagi aktif diikuti siswa yang login.
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $jadwal = DB::table('pendaftaran')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->join('jadwal_kelas', 'jadwal_kelas.pendaftaran_id', '=', 'pendaftaran.id')
            ->where('pendaftaran.user_id', $userId)
            ->where('pendaftaran.status', 'aktif')
            ->select(
                'jadwal_kelas.id',
                'jadwal_kelas.hari',
                'jadwal_kelas.jam_mulai',
                'jadwal_kelas.jam_selesai',
                'jadwal_kelas.ruangan',
                'program_kursus.nama_program as program'
            )
            ->orderByRaw("FIELD(jadwal_kelas.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jadwal_kelas.jam_mulai')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $jadwal,
        ], 200);
    }
}
