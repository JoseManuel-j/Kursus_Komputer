<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    // Bentuk data user yang dikirim balik ke client, sesuai skema di laporan KKP
    // (nama_lengkap, bukan `name` mentah dari kolom database)
    private function formatUser(User $user): array
    {
        return [
            'id'             => $user->id,
            'nama_lengkap'   => $user->name,
            'email'          => $user->email,
            'nomor_telepon'  => $user->nomor_hp,
        ];
    }

    // POST /api/register — Rancangan Endpoint Register (3.5.1.1)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap'          => 'required|string|max:255',
            'email'                 => 'required|email',
            'nomor_telepon'         => 'nullable|string|max:20',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Sama kayak alur web: email nggak dicek unique langsung. Kalau udah
        // kepake tapi BELUM diverifikasi, dianggap akun nyasar (typo email
        // pas daftar) dan ditimpa. Kalau udah verified, baru ditolak beneran.
        $existing = User::where('email', $request->email)->first();

        if ($existing) {
            if (! is_null($existing->email_verified_at)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Email ini sudah terdaftar dan sudah diverifikasi. Silakan login.',
                ], 422);
            }

            $existing->delete();
        }

        $user = User::create([
            'name'     => $request->nama_lengkap,
            'email'    => $request->email,
            'nomor_hp' => $request->nomor_telepon,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        // Sama kayak alur registrasi di web: kirim email verifikasi dulu.
        // Dibungkus try/catch: kalau server email lagi down/timeout, akun
        // TETAP kebuat (nggak nge-500 total), siswa tinggal minta kirim
        // ulang link verifikasi nanti dari halaman /email/verify.
        try {
            event(new Registered($user));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal kirim email verifikasi: ' . $e->getMessage());
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Registrasi berhasil. Silakan cek email untuk verifikasi sebelum login.',
            'data'    => $this->formatUser($user),
            'token'   => $token,
        ], 201);
    }

    // POST /api/login — Rancangan Endpoint Login User (3.5.1.2)
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Email dan password wajib diisi.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Cuma siswa yang boleh login lewat mobile app
        if ($user->role !== 'siswa') {
            return response()->json([
                'status'  => false,
                'message' => 'Akun ini tidak memiliki akses ke aplikasi mobile.',
            ], 403);
        }

        // Siswa wajib verifikasi email dulu (link verifikasi dikirim pas registrasi)
        if (is_null($user->email_verified_at)) {
            return response()->json([
                'status'  => false,
                'message' => 'Email kamu belum diverifikasi. Cek inbox/spam email kamu untuk link verifikasi.',
            ], 403);
        }

        // Hapus token lama biar nggak numpuk tiap kali login ulang di device yang sama
        $user->tokens()->where('name', 'mobile-app')->delete();

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login berhasil.',
            'data'    => $this->formatUser($user),
            'token'   => $token,
        ], 200);
    }

    // POST /api/logout — Rancangan Endpoint Logout (3.5.1.4)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logout berhasil.',
        ], 200);
    }

    // GET /api/me — alias lama, dipertahankan biar kompatibel; isinya sama kayak /api/profile
    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'data'   => $this->formatUser($request->user()),
        ], 200);
    }
}
