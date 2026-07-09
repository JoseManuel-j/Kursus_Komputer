<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKursus extends Model
{
    use HasFactory;

    protected $table = 'program_kursus';
    protected $guarded = ['id'];

    // Relasi ke Jadwal Kelas
    public function jadwal()
    {
        return $this->hasMany(JadwalKelas::class, 'program_kursus_id');
    }
}