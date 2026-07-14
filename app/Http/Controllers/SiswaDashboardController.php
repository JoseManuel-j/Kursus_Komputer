<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran; 

class SiswaDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data siswa yang sedang login
        $siswa = Auth::user();
        
        // 2. Ambil pendaftaran, program, dan jadwal
        $pendaftaran = Pendaftaran::with(['programKursus', 'jadwal', 'tagihan'])
                        ->where('user_id', $siswa->id)
                        ->get();

        // 3. LOGIKA PERHITUNGAN SISA BAYAR 
// Di dalam loop foreach($pendaftaran as $item) di SiswaDashboardController.php
foreach ($pendaftaran as $item) {
    // Ambil semua tagihan untuk pendaftaran ini
    $tagihans = DB::table('tagihan')->where('pendaftaran_id', $item->id)->get();
    
    // Total biaya kursus
    $biaya = $item->programKursus->biaya ?? 0;
    
    // Hitung total yang sudah dibayar (status lunas)
    $totalDibayar = $tagihans->where('status', 'lunas')->sum('jumlah');
    
    // Tentukan status dan sisa
    $item->sisa_bayar = $biaya - $totalDibayar;
    
    // Ambil status dari tagihan terakhir atau tentukan sendiri
    $item->status_bayar = $tagihans->isNotEmpty() ? $tagihans->last()->status : 'belum_ada';
}

        $aktivitas = DB::table('riwayat_aktivitas')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 4. Lempar datanya ke tampilan
        return view('dashboard', compact('pendaftaran', 'aktivitas'));
    }
}