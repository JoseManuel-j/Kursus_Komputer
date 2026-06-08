<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Fungsi untuk memproses data dari formulir
    public function store(Request $request)
    {
        // 1. Validasi keamanan tambahan di sisi server (Backend)
        $request->validate([
            'name'  => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|min:10|max:13'
        ]);

        // 2. Di sini biasanya adalah tempat kamu menyimpan data ke database
        // Contoh jika menggunakan model User:
        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        // ]);

        // 3. Mengembalikan pengguna ke halaman formulir dengan pesan sukses
        return back()->with('success', 'Registrasi berhasil dilakukan!');
    }
}