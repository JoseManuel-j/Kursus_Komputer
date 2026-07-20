<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';
    protected $guarded = ['id'];

    // Relasi ke Pendaftaran (jadwal nempel ke pendaftaran siswa spesifik,
    // bukan ke program_kursus secara langsung)
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id');
    }
}