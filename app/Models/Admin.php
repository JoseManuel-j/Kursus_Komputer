<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

// NOTE: Ini tabel `admins` yang TERPISAH dari tabel `users` (yang juga
// punya role='admin'). Sesuai rancangan laporan KKP (endpoint
// /api/admin/login pakai token dengan ability 'role:admin'), dipakai
// khusus buat autentikasi API admin. Login web admin yang sudah ada
// (lewat AuthController + tabel users) TETAP JALAN seperti biasa —
// model ini cuma nambahin jalur baru sesuai spesifikasi laporan.
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'admins';
    protected $guarded = ['id'];
    protected $hidden = ['password'];
}
