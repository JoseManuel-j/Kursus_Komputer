<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminApiSeeder extends Seeder
{
    // Ini buat akun login admin di API mobile (/api/admin/login), tabel `admins`
    // — TERPISAH dari akun admin di tabel `users` yang dipakai buat login web.
    // Ganti password ini sebelum di-deploy ke server production ya!
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            ['password' => Hash::make('phitagoras123')]
        );
    }
}
