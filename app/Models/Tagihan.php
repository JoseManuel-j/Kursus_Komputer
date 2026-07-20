<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';
    protected $guarded = ['id'];

    protected $casts = [
        'jumlah'       => 'decimal:2',
        'jatuh_tempo'  => 'date',
    ];

    // Relasi ke Pendaftaran induknya
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    // Riwayat pembayaran/cicilan untuk tagihan ini
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_id');
    }

    // Total yang sudah masuk lewat tabel `pembayaran` (dipakai Api\TagihanController)
    public function getTotalDibayarAttribute()
    {
        // Kalau relasi 'pembayaran' sudah di-load (eager load), hitung dari collection
        // biar nggak query ulang ke DB tiap kali accessor ini dipanggil.
        if ($this->relationLoaded('pembayaran')) {
            return $this->pembayaran->sum('jumlah_bayar');
        }

        return $this->pembayaran()->sum('jumlah_bayar');
    }

    // Sisa yang harus dibayar siswa untuk tagihan ini
    public function getSisaTagihanAttribute()
    {
        return max(0, (float) $this->jumlah - (float) $this->total_dibayar);
    }
}
