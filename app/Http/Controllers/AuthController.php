<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // REGISTER VIEW
    public function showRegister()
    {
        return view('register');
    }

    // REGISTER PROCESS
    public function register(Request $request)
    {
        // Validasi input dari form (ditambahkan phone agar sesuai dengan form HTML)
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users', 
            'phone' => 'required|min:10', // Menangkap input form telepon
            'password' => 'required|min:8' // Disesuaikan dengan minimal 8 karakter di HTML
        ]);

        // Pakai Eloquent User::create dan PAKSA role jadi 'siswa'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_hp' => $request->phone, // Pastikan nama kolom di database kamu benar 'nomor_hp'. Jika namanya beda, sesuaikan.
            'password' => Hash::make($request->password),
            'role' => 'siswa' // <-- Tambahan wajib biar otomatis jadi murid
        ]);

        // Mengarahkan langsung ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
    }

    // LOGIN VIEW
    public function showLogin()
    {
        return view('login');
    }

    // LOGIN PROCESS
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Proses login bawaan Laravel
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            // JALAN SIHIRNYA DI SINI: Cek role user yang baru login
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/admin/dashboard'); // Lempar ke dashboard admin
            } elseif ($role === 'instruktur') {
                return redirect('/instruktur/jadwal'); // Lempar ke halaman instruktur
            }

            return redirect('/dashboard'); // Kalau bukan admin & instruktur, pasti siswa
        }

        return back()->with('error', 'Email atau password salah');
    }

    // DASHBOARD
    public function dashboard()
    {
        return view('dashboard');
    }

    // LOGOUT (Diperbaiki)
    public function logout(Request $request)
    {
        // 1. Proses mengeluarkan akun
        Auth::logout();
        
        // 2. Menghapus sesi secara total untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Melempar kembali ke halaman login
        return redirect('/login');
    }
}