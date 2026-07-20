<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthApiController extends Controller
{
    // POST /api/admin/login — Rancangan Endpoint Login Admin (3.5.1.3)
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Username dan password wajib diisi.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $admin = Admin::where('username', $request->username)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        // Token dengan ability 'role:admin' — dicek middleware admin.api / EnsureAdminApi
        $token = $admin->createToken('admin-panel', ['role:admin'])->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login admin berhasil.',
            'data'    => [
                'id'       => $admin->id,
                'username' => $admin->username,
            ],
            'token'   => $token,
        ], 200);
    }
}
