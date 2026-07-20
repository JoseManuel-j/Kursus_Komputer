<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Instruktur extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'instrukturs';
    protected $guarded = ['id'];
    protected $hidden = ['password'];

    public function jadwal()
    {
        return $this->hasMany(JadwalKelas::class, 'instruktur_id');
    }
}
