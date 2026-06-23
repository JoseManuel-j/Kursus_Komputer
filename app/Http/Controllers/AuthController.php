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
            'phone'         => 'required|min:10|max:13', 
            'password'      => 'required|min:8|confirmed' 
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
            'nomor_hp'      => $request->phone, // Diperbaiki: Harus 'nomor_hp'
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

    // UPDATE DATA SISWA OLEH ADMIN
    public function updateSiswaByAdmin(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'nomor_hp'      => 'required|min:10|max:13',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string',
            'alamat'        => 'required|string',
        ]);

        $siswa = User::findOrFail($id);
        
        $siswa->update([
            'name'          => $request->name,
            'nomor_hp'      => $request->phone,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
        ]);

        return back()->with('success', 'Data biodata siswa berhasil diperbarui oleh Admin!');
    }
} // Tanda kurung kurawal penutup class sekarang sudah benar di paling bawah