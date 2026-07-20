<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrukturController extends Controller
{
    public function jadwalMengajar(Request $request)
    {
        // Ambil ID instruktur yang lagi login (asumsi pakai token)
        $instrukturId = $request->user()->id;

        // Tarik data jadwal yang nyambung sama ID instruktur ini
        // (jadwal_kelas -> pendaftaran -> program_kursus, BUKAN langsung ke program_kursus
        // karena jadwal_kelas nempel ke pendaftaran spesifik seorang siswa, bukan ke program)
        $jadwal = DB::table('jadwal_kelas')
            ->join('pendaftaran', 'jadwal_kelas.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
            ->join('users', 'pendaftaran.user_id', '=', 'users.id')
            ->where('jadwal_kelas.instruktur_id', $instrukturId)
            ->select('program_kursus.nama_program', 'users.name as nama_siswa', 'jadwal_kelas.hari', 'jadwal_kelas.jam_mulai', 'jadwal_kelas.jam_selesai', 'jadwal_kelas.ruangan')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil jadwal mengajar',
            'data' => $jadwal
        ], 200);
    }
}