<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Bikin akun Admin murni
        User::create([
            'name' => 'Admin Phitagoras',
            'email' => 'admin@phitagoras.site', 
            'password' => Hash::make('teemoslayer'),
            'role' => 'admin', 
            'email_verified_at' => now(), // admin nggak perlu verifikasi email
        ]);
    }
}