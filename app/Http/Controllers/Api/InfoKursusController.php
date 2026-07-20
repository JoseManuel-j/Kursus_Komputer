<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfoKursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfoKursusController extends Controller
{
    // GET /api/info-kursus — Rancangan Endpoint Info Kursus (3.5.1.5), publik
    public function index()
    {
        // Cuma ada 1 baris info lembaga. Kalau belum ada sama sekali,
        // buatin default dulu biar endpoint ini nggak pernah null.
        $info = InfoKursus::first();

        if (! $info) {
            $info = InfoKursus::create([
                'nama_tempat'     => 'LKP Phitagoras',
                'alamat'          => 'Tangerang Selatan, Banten',
                'nomor_telepon'   => '-',
                'jam_operasional' => 'Senin - Sabtu, 08.00 - 17.00',
                'hero_judul'      => 'Kursus Komputer Phitagoras',
                'hero_deskripsi'  => 'Lembaga kursus komputer di Tangerang Selatan.',
            ]);
        }

        return response()->json([
            'status' => true,
            'data'   => $info,
        ], 200);
    }

    // PUT /api/admin/info-kursus — Rancangan Endpoint Update Info Kursus (3.5.1.6), admin only
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_tempat'     => 'required|string|max:255',
            'alamat'          => 'required|string',
            'nomor_telepon'   => 'required|string|max:20',
            'jam_operasional' => 'required|string|max:100',
            'hero_judul'      => 'required|string|max:255',
            'hero_deskripsi'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $info = InfoKursus::first();

        if ($info) {
            $info->update($validator->validated());
        } else {
            $info = InfoKursus::create($validator->validated());
        }

        return response()->json([
            'status'  => true,
            'message' => 'Informasi kursus berhasil diperbarui.',
            'data'    => $info,
        ], 200);
    }
}
