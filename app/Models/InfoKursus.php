<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKursus extends Model
{
    use HasFactory;

    protected $table = 'info_kursus';
    protected $guarded = ['id'];
}
