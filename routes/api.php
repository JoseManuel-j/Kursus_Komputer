<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\InstrukturController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AdminAuthApiController;
use App\Http\Controllers\Api\TagihanController;
use App\Http\Controllers\Api\JadwalSiswaController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\InfoKursusController;
use App\Http\Controllers\Api\FotoKegiatanController;
use App\Http\Controllers\Api\AdminUserController;

// Rute default bawaan Laravel buat ngecek data user login (pakai token)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| ENDPOINT SESUAI RANCANGAN BAB 3.5.1 LAPORAN KKP
| (nomor di komentar = nomor sub-bab rancangan endpoint di laporan)
|--------------------------------------------------------------------------
*/

// 3.5.1.1 & 3.5.1.2 — Register & Login user (siswa)
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// 3.5.1.3 — Login admin (token terpisah, tabel `admins`)
Route::post('/admin/login', [AdminAuthApiController::class, 'login']);

// 3.5.1.5 — Info kursus (publik)
Route::get('/info-kursus', [InfoKursusController::class, 'index']);

// 3.5.1.7 — Foto kegiatan (publik, cuma yang aktif)
Route::get('/foto-kegiatan', [FotoKegiatanController::class, 'index']);

// Endpoint publik lain yang udah ada dari sebelumnya
Route::get('/program-kursus', [ProgramController::class, 'index']);

/*
|--------------------------------------------------------------------------
| BUTUH LOGIN (siswa ATAU admin, tergantung endpoint)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // 3.5.1.4 — Logout (siswa maupun admin)
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Alias lama, dipertahankan biar mobile app yang udah kepasang nggak putus
    Route::get('/me', [AuthApiController::class, 'me']);

    // 3.5.1.11, 3.5.1.12, 3.5.1.13 — Profil & ganti password (siswa yang login)
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/ganti-password', [ProfileController::class, 'gantiPassword']);

    /*
    |----------------------------------------------------------------------
    | KHUSUS SISWA — path /api/siswa/...
    |----------------------------------------------------------------------
    */
    // 3.5.1.16 — Jadwal kelas
    Route::get('/siswa/jadwal', [JadwalSiswaController::class, 'index']);

    // 3.5.1.17 — Rekap absensi
    Route::get('/siswa/absensi', [AbsensiController::class, 'index']);

    // 3.5.1.18, 3.5.1.19, 3.5.1.20 — Tagihan, bayar, riwayat pembayaran
    Route::get('/siswa/tagihan', [TagihanController::class, 'siswaTagihan']);
    Route::post('/siswa/bayar', [TagihanController::class, 'siswaBayar']);
    Route::get('/siswa/riwayat-pembayaran', [TagihanController::class, 'riwayatPembayaran']);

    // Endpoint tagihan versi lama/lebih detail — TETAP DIPAKAI mobile app
    // (ada breakdown cicilan per tagihan buat layar "Lihat Angsuran")
    Route::get('/tagihan', [TagihanController::class, 'index']);
    Route::get('/tagihan/{id}', [TagihanController::class, 'show']);
    Route::post('/tagihan/{id}/bayar', [TagihanController::class, 'bayar']);

    // Instruktur
    Route::get('/instruktur/jadwal', [InstrukturController::class, 'jadwalMengajar']);

    /*
    |----------------------------------------------------------------------
    | KHUSUS ADMIN — path /api/admin/... (butuh token admin, dicek middleware admin.api)
    |----------------------------------------------------------------------
    */
    Route::middleware('admin.api')->prefix('admin')->group(function () {
        // 3.5.1.6 — Update info kursus
        Route::put('/info-kursus', [InfoKursusController::class, 'update']);

        // 3.5.1.8, 3.5.1.9, 3.5.1.10 — Kelola foto kegiatan
        Route::post('/foto-kegiatan', [FotoKegiatanController::class, 'store']);
        Route::patch('/foto-kegiatan/{id}/toggle', [FotoKegiatanController::class, 'toggle']);
        Route::delete('/foto-kegiatan/{id}', [FotoKegiatanController::class, 'destroy']);

        // 3.5.1.14, 3.5.1.15 — Kelola user
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);
    });
});
