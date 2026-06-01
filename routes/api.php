<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramController; // <-- Jangan lupa import controllernya

// Ini rute default bawaan Laravel buat ngecek data user login (pakai token)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- TAMBAHIN RUTE API LU DI BAWAH SINI ---

// Endpoint buat ngambil daftar 28 kelas kursus
Route::get('/program-kursus', [ProgramController::class, 'index']);