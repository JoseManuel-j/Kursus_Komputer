<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $guarded = ['id'];

    protected $casts = [
        'jumlah_bayar'  => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    // Relasi ke Tagihan induknya
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }
}
