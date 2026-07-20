<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    // GET /api/siswa/absensi — Rancangan Endpoint Absensi Siswa (3.5.1.17)
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $pendaftaranIds = DB::table('pendaftaran')
            ->where('user_id', $userId)
            ->pluck('id');

        $absensi = DB::table('absensi')
            ->whereIn('pendaftaran_id', $pendaftaranIds)
            ->orderByDesc('tanggal')
            ->get(['tanggal', 'status']);

        $rekap = [
            'total_hadir' => $absensi->where('status', 'hadir')->count(),
            'total_izin'  => $absensi->where('status', 'izin')->count(),
            'total_sakit' => $absensi->where('status', 'sakit')->count(),
            'total_alpha' => $absensi->where('status', 'alpha')->count(),
            'detail'      => $absensi->map(fn ($a) => [
                'tanggal' => $a->tanggal,
                'status'  => $a->status,
            ])->values(),
        ];

        return response()->json([
            'status' => true,
            'data'   => $rekap,
        ], 200);
    }
}
