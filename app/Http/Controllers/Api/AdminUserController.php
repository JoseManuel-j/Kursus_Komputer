<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    // GET /api/admin/users — Rancangan Endpoint Daftar User (3.5.1.14), admin only
    public function index()
    {
        $users = User::where('role', 'siswa')
            ->select('id', 'name as nama_lengkap', 'email', 'nomor_hp', 'created_at')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $users,
        ], 200);
    }

    // DELETE /api/admin/users/{id} — Rancangan Endpoint Hapus User (3.5.1.15), admin only
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['status' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        // Hapus token akses aktif dulu, baru hapus user-nya
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'User berhasil dihapus.',
        ], 200);
    }
}
