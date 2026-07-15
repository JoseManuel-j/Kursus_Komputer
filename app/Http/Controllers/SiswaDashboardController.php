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

        // 3. LOGIKA PERHITUNGAN SISA BAYAR & STATUS
        // FIX: rumus ini sekarang SAMA PERSIS dengan admin/tagihan, admin/dashboard,
        // dan /angsuran, supaya angka sisa bayar & status tidak lagi beda-beda
        // antar halaman.
        foreach ($pendaftaran as $item) {
            // Ambil semua tagihan untuk pendaftaran ini
            $tagihans = DB::table('tagihan')->where('pendaftaran_id', $item->id)->get();

            // Total biaya kursus
            $biaya = $item->programKursus->biaya ?? 0;

            // FIX: cicilan yang sudah dibayar juga dihitung sebagai uang masuk,
            // bukan cuma yang statusnya 'lunas'. Sebelumnya baris ini cuma
            // where('status', 'lunas') sehingga cicilan yang sudah dibayar
            // diabaikan dan sisa bayar jadi salah (kelihatan seperti belum
            // bayar sama sekali).
            // Hanya hitung yang statusnya benar-benar 'lunas' sebagai uang masuk
            $totalDibayar = $tagihans->where('status', 'lunas')->sum('jumlah');

            $item->sisa_bayar = max(0, $biaya - $totalDibayar);

            // FIX: status_bayar sekarang dihitung dari KESELURUHAN tagihan
            // pendaftaran ini, bukan dari satu baris tagihan acak
            // (sebelumnya blade memakai $item->tagihan->status yang berasal
            // dari relasi Eloquent tunggal — bisa saja itu bukan tagihan
            // yang mencerminkan status kelas secara keseluruhan).
            if ($biaya > 0 && $item->sisa_bayar <= 0) {
                $item->status_bayar = 'lunas';
            } elseif ($totalDibayar > 0) {
                // Jika ada pembayaran masuk tapi sisa masih ada, statusnya CICILAN
                $item->status_bayar = 'cicilan';
            } elseif ($tagihans->contains('status', 'pending')) {
                $item->status_bayar = 'pending';
            } else {
                $item->status_bayar = 'belum_ada';
            }
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