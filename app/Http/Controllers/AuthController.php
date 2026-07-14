<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'email'         => 'required|string|email|max:255|unique:users', 
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string',
            'alamat'        => 'required|string',
            'nomor_hp'      => 'required|string|min:10|max:13', 
            'password'      => 'required|string|min:8|confirmed' // Pastikan ada input 'password_confirmation' di view
        ]);

        User::create([
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

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
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
            $request->session()->regenerate();
            $role = Auth::user()->role;

            // Redirect berdasarkan Role
            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'instruktur') {
                return redirect('/instruktur/jadwal');
            }

            // Default ke dashboard siswa
            return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
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
    // 3. FITUR LUPA PASSWORD 
    // =========================================================================
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        return back()->with('success', 'Email berhasil diverifikasi! Sistem pengiriman kode dikesampingkan dulu.');
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