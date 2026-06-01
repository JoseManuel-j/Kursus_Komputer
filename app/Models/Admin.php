<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    // Kolom yang boleh diisi
    protected $fillable = [
        'username',
        'password',
    ];

    // Sembunyiin password kalau datanya dipanggil
    protected $hidden = [
        'password',
    ];
}