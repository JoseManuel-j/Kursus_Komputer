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
        foreach ($pendaftaran as $item) {
            $totalMasuk = DB::table('tagihan')
                ->where('pendaftaran_id', $item->id)
                ->where('status', 'lunas')
                ->sum('jumlah');

            // JAGA-JAGA: Kalau data programnya null/hilang, anggap biayanya 0
            $biayaProgram = $item->programKursus->biaya ?? 0; 
            
            // Hitung sisa bayar
            $item->sisa_bayar = $biayaProgram - $totalMasuk;
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