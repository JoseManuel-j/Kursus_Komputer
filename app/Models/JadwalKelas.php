<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';
    protected $guarded = ['id'];

    // Relasi balik ke Program Kursus
    public function programKursus()
    {
        return $this->belongsTo(ProgramKursus::class, 'program_kursus_id');
    }
}