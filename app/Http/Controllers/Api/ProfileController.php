<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // GET /api/profile — Rancangan Endpoint Profil User (3.5.1.11)
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'data'   => [
                'id'            => $user->id,
                'nama_lengkap'  => $user->name,
                'email'         => $user->email,
                'nomor_telepon' => $user->nomor_hp,
            ],
        ], 200);
    }

    // PUT /api/profile — Rancangan Endpoint Update Profil (3.5.1.12)
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap'  => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $user->update([
            'name'     => $request->nama_lengkap,
            'nomor_hp' => $request->nomor_telepon,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Profil berhasil diperbarui.',
            'data'    => [
                'nama_lengkap'  => $user->name,
                'nomor_telepon' => $user->nomor_hp,
            ],
        ], 200);
    }

    // PUT /api/ganti-password — Rancangan Endpoint Ganti Password (3.5.1.13)
    public function gantiPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama'              => 'required|string',
            'password_baru'               => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        if (! Hash::check($request->password_lama, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Password lama salah.',
            ], 422);
        }

        $user->update(['password' => Hash::make($request->password_baru)]);

        // Hapus semua token/sesi aktif (di HP lain juga ke-logout), sesuai laporan
        $user->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Password berhasil diperbarui. Silakan login kembali.',
        ], 200);
    }
}
