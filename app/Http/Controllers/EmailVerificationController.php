<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    // Halaman "Cek email kamu" yang muncul kalau siswa coba login sebelum verifikasi.
    public function notice(Request $request)
    {
        return view('verify-email', [
            'email' => $request->session()->get('unverified_email', optional(Auth::user())->email),
        ]);
    }

    // Dipanggil pas siswa klik link verifikasi di email (signed URL, expire otomatis).
    // Route ini SENGAJA tidak pakai middleware 'auth': di app ini, siswa belum
    // login otomatis setelah daftar (register() cuma redirect ke /login), jadi
    // pas mereka klik link di email, mereka belum tentu punya sesi login aktif.
    // Verifikasi tetap aman karena sudah dilindungi middleware 'signed' (URL
    // di-generate dengan tanda tangan + expire, dan hash email dicocokkan manual).
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('success', 'Email kamu sudah terverifikasi sebelumnya. Silakan login.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect('/login')->with('success', 'Email berhasil diverifikasi! Sekarang kamu bisa login.');
    }

    // Kirim ulang link verifikasi (dipakai dari halaman notice / halaman login pas gagal karena belum verified)
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('success', 'Email kamu sudah terverifikasi. Silakan login.');
        }

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal kirim ulang email verifikasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email. Coba lagi beberapa saat lagi.');
        }

        return back()->with('success', 'Link verifikasi baru sudah dikirim ke ' . $user->email . '. Cek inbox/spam ya!')
                      ->with('unverified_email', $user->email);
    }
}
