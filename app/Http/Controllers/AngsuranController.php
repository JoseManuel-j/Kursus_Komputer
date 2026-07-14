<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function index()
    {
        // Nantinya di sini Anda memanggil data dari database, contoh:
        // $angsuran = Angsuran::where('user_id', auth()->id())->get();
        
        return view('siswa.angsuran'); // Mengarahkan ke file view blade
    }
}