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
        // Validasi input dari form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:6'
        ]);

        // Pakai Eloquent User::create dan PAKSA role jadi 'siswa'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa' // <-- Tambahan wajib biar otomatis jadi murid
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat!');
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

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}