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
        // 1. Validasi input ditambah dengan field biodata baru
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users', 
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required',
            'alamat'        => 'required',
            'phone'         => 'required|min:10|max:13', 
            'password'      => 'required|min:8|confirmed' 
        ]);

        // 2. Menyimpan user baru ke database beserta biodatanya
        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
            'Phone'      => $request->phone, // Pastikan nama kolom di database kamu adalah 'nomor_hp'
            'password'      => Hash::make($request->password),
            'role'          => 'siswa' // Role default untuk registrasi
        ]);

        // 3. Redirect ke login dengan notifikasi sukses
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

        // Cek kredensial
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            // Cek role untuk menentukan tujuan dashboard
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'instruktur') {
                return redirect('/instruktur/jadwal');
            }

            return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // Jika gagal
        return back()->with('error', 'Email atau password salah.');
    }

    // DASHBOARD (Siswa)
    public function dashboard()
    {
        return view('dashboard');
    }

    // LOGOUT (Sesuai keamanan standar Laravel)
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}