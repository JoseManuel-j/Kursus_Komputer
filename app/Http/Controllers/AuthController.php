<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordOtp;
use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // =========================================================================
    // 1. REGISTRASI
    // =========================================================================
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Pastikan input form di view register.blade.php memiliki nama yang sesuai
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string',
            'alamat'        => 'required|string',
            'nomor_hp'      => 'required|string|min:10|max:13', 
            'password'      => 'required|string|min:8|confirmed' // Pastikan ada input 'password_confirmation' di view
        ]);

        // Email SENGAJA nggak dicek 'unique' di validasi di atas. Alesannya:
        // kalau orang salah ketik email pas daftar, akunnya bakal permanen
        // ke-lock (nggak bisa verifikasi karena emailnya salah/nggak ada,
        // padahal itu VALUE-nya nggak kepake siapa-siapa beneran). Jadi di
        // sini dicek manual: kalau email udah kepake TAPI belum diverifikasi,
        // anggap itu akun "nyasar" -> timpa aja sama data pendaftaran baru.
        // Kalau udah keverifikasi, baru bener-bener ditolak (emang punya orang).
        $existing = User::where('email', $request->email)->first();

        if ($existing) {
            if (! is_null($existing->email_verified_at)) {
                return back()
                    ->withErrors(['email' => 'Email ini sudah terdaftar dan sudah diverifikasi. Silakan login atau pakai Lupa Password kalau lupa password kamu.'])
                    ->withInput();
            }

            // Belum diverifikasi -> hapus akun lama yang nyasar itu, ganti data baru
            $existing->delete();
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
            'nomor_hp'      => $request->nomor_hp,
            'password'      => Hash::make($request->password),
            'role'          => 'siswa' // <--- Otomatis menjadi siswa
        ]);

        // Kirim email verifikasi (link aman/signed) ke email yang baru daftar.
        // Siswa harus klik link ini dulu sebelum bisa login (dicek di method login()).
        // Dibungkus try/catch biar kalau server email lagi bermasalah, akunnya
        // tetap kebuat & siswa nggak ngalamin error 500 pas daftar.
        try {
            event(new Registered($user));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal kirim email verifikasi: ' . $e->getMessage());
        }

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Kami sudah kirim link verifikasi ke email kamu, silakan cek inbox (atau folder spam) sebelum login ya.');
    }

    // =========================================================================
    // 2. LOGIN & LOGOUT
    // =========================================================================
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();

            // Siswa wajib verifikasi email dulu sebelum bisa login.
            // (Admin/instruktur dikecualikan karena akunnya dibuat manual, bukan lewat form registrasi publik.)
            if ($user->role === 'siswa' && is_null($user->email_verified_at)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->with('error', 'Email kamu belum diverifikasi. Cek inbox/spam email kamu, atau klik link kirim ulang di bawah.')
                              ->with('unverified_email', $data['email']);
            }

            $request->session()->regenerate();
            $role = $user->role;

            // Redirect berdasarkan Role
            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'instruktur') {
                return redirect('/instruktur/jadwal');
            }

            // Default ke dashboard siswa
            return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }

    // =========================================================================
    // 3. FITUR LUPA PASSWORD (OTP dikirim dari admin@phitagoras.site)
    // =========================================================================

    // STEP 1: Form input email
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    // STEP 1 (proses): Validasi email lalu kirim kode OTP 6 digit
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Demi keamanan, pesan yang ditampilkan sengaja sama persis baik email
        // terdaftar maupun tidak (biar orang luar nggak bisa nebak-nebak email
        // mana yang punya akun di sistem kita / user enumeration).
        $pesanUmum = 'Kalau email tersebut terdaftar, kode OTP sudah kami kirim. Silakan cek inbox/spam.';

        if (! $user) {
            return back()->with('success', $pesanUmum);
        }

        // Hapus OTP lama punya email ini biar nggak numpuk / dipakai lagi
        PasswordOtp::where('email', $user->email)->delete();

        $otp = (string) random_int(100000, 999999);

        PasswordOtp::create([
            'email'      => $user->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new ForgotPasswordOtpMail($otp));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal kirim email OTP: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email. Coba lagi beberapa saat lagi.');
        }

        session([
            'otp_email'    => $user->email,
            'otp_verified' => false,
        ]);

        return redirect()->route('password.otp.form')->with('success', $pesanUmum);
    }

    // STEP 2: Form input kode OTP
    public function showVerifyOtp(Request $request)
    {
        if (! session('otp_email')) {
            return redirect()->route('password.request')->with('error', 'Silakan masukkan email kamu dulu.');
        }

        return view('verify-otp', ['email' => session('otp_email')]);
    }

    // STEP 2 (proses): Cek kode OTP yang diinput siswa
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('password.request')->with('error', 'Sesi kamu habis, silakan mulai ulang dari awal.');
        }

        $otpRecord = PasswordOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->latest('id')
            ->first();

        if (! $otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah. Coba cek lagi email kamu.']);
        }

        if ($otpRecord->isExpired()) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        $otpRecord->update(['verified_at' => now()]);

        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    // Kirim ulang OTP (dari halaman verify-otp, kalau belum nerima/expired)
    public function resendOtp(Request $request)
    {
        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('password.request')->with('error', 'Silakan masukkan email kamu dulu.');
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            PasswordOtp::where('email', $email)->delete();

            $otp = (string) random_int(100000, 999999);

            PasswordOtp::create([
                'email'      => $email,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(10),
            ]);

            try {
                Mail::to($email)->send(new ForgotPasswordOtpMail($otp));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal kirim ulang email OTP: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengirim email. Coba lagi beberapa saat lagi.');
            }
        }

        return back()->with('success', 'Kode OTP baru sudah dikirim ulang ke email kamu.');
    }

    // STEP 3: Form password baru + konfirmasi password
    public function showResetPassword(Request $request)
    {
        if (! session('otp_email') || ! session('otp_verified')) {
            return redirect()->route('password.request')->with('error', 'Silakan verifikasi kode OTP dulu.');
        }

        return view('reset-password', ['email' => session('otp_email')]);
    }

    // STEP 3 (proses): Simpan password baru
    public function resetPassword(Request $request)
    {
        $email = session('otp_email');

        if (! $email || ! session('otp_verified')) {
            return redirect()->route('password.request')->with('error', 'Silakan verifikasi kode OTP dulu.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed', // wajib ada input password_confirmation
        ]);

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('password.request')->with('error', 'Akun tidak ditemukan.');
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Bersih-bersih: hapus semua OTP punya email ini + hapus sesi sementara
        PasswordOtp::where('email', $email)->delete();
        $request->session()->forget(['otp_email', 'otp_verified']);

        return redirect('/login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru kamu.');
    }

    // =========================================================================
    // 4. KELOLA DATA OLEH ADMIN
    // =========================================================================
    public function updateSiswaByAdmin(Request $request, string $id)
    {
        // Validasi 'nullable' agar admin bisa edit sebagian data saja tanpa error
        $request->validate([
            'name'          => 'required|string|max:255',
            'nomor_hp'      => 'nullable|string|min:10|max:13',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama'         => 'nullable|string',
            'alamat'        => 'nullable|string',
        ]);

        $siswa = User::findOrFail($id);
        
        $siswa->update([    
            'name'          => $request->name,
            'nomor_hp'      => $request->nomor_hp,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
        ]);

        return back()->with('success', 'Data biodata siswa berhasil diperbarui oleh Admin!');
    }
}