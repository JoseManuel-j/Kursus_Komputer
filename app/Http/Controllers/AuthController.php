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
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users', 
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required',
            'alamat'        => 'required',
            'nomor_hp'      => 'required|min:10|max:13', 
            'password'      => 'required|min:8|confirmed' 
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
            'nomor_hp'      => $request->nomor_hp, // Diperbaiki: Harus 'nomor_hp'
            'password'      => Hash::make($request->password),
            'role'          => 'siswa'
        ]);

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
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'instruktur') {
                return redirect('/instruktur/jadwal');
            }

            return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // DASHBOARD (Siswa)
    public function dashboard()
    {
        return view('dashboard');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }

    // --- FITUR LUPA PASSWORD (TAMBAHAN) ---
    
    // 1. Menampilkan halaman input email saja
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    // 2. Aksi verifikasi email (sementara dikembalikan ke halaman dengan alert)
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        return back()->with('success', 'Email berhasil diverifikasi! Sistem pengiriman kode dikesampingkan dulu.');
    }

    // UPDATE DATA SISWA OLEH ADMIN
    public function updateSiswaByAdmin(Request $request, $id)
    {
        // 1. Ubah validasi ke 'nullable' agar admin bisa edit sebagian data saja
        $request->validate([
            'name'          => 'required|string|max:255',
            'nomor_hp'      => 'nullable|min:10|max:13',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama'         => 'nullable|string',
            'alamat'        => 'nullable|string',
        ]);

        $siswa = User::findOrFail($id);
        
        // 2. Update data
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