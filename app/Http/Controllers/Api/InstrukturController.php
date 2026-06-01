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
        $jadwal = DB::table('jadwal_kelas')
            ->join('program_kursus', 'jadwal_kelas.program_id', '=', 'program_kursus.id')
            ->where('jadwal_kelas.instruktur_id', $instrukturId)
            ->select('program_kursus.nama_program', 'jadwal_kelas.hari', 'jadwal_kelas.jam_mulai', 'jadwal_kelas.jam_selesai', 'jadwal_kelas.ruangan')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil jadwal mengajar',
            'data' => $jadwal
        ], 200);
    }
}