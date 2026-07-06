<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKursus extends Model
{
    protected $table = 'program_kursus';

    protected $fillable = [
        'nama_program',
        'tipe_kelas',
        'deskripsi',
        'jumlah_sesi',
        'biaya',
    ];
}