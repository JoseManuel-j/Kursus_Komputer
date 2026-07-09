<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran'; // Sesuaikan dengan nama tabel di database kamu
    protected $guarded = ['id'];

    // Relasi balik ke User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Program Kursus
    public function programKursus()
    {
        return $this->belongsTo(ProgramKursus::class, 'program_id');
    }

    // Relasi ke Jadwal Kelas (karena jadwal sekarang nyambung ke pendaftaran_id)
    public function jadwal()
    {
        return $this->hasMany(JadwalKelas::class, 'pendaftaran_id');
    }
}