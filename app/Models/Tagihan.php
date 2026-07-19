<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'pendaftaran_id',
        'jumlah',
        'status',
        'jatuh_tempo',
        'buktiTransfer',
        'tanggal_bayar',
    ];
}