<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    use HasFactory;

    public $timestamps = false; // tabel ini cuma punya created_at, bukan updated_at

    protected $table = 'riwayat_aktivitas';
    protected $guarded = ['id'];

    protected $attributes = [
        // created_at di-set default CURRENT_TIMESTAMP oleh DB sendiri
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
