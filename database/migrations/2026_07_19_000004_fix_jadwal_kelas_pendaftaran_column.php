<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// PENTING — cerita kenapa migration ini ada:
// Migration lama (2026_05_29_072117_create_phitagoras_tables) bikin
// `jadwal_kelas.program_id` (relasi ke program_kursus). Tapi di database
// PRODUKSI kolom itu udah diganti manual (lewat phpMyAdmin, bukan migration)
// jadi `jadwal_kelas.pendaftaran_id` (relasi ke pendaftaran, bukan ke
// program_kursus) — supaya 1 jadwal nempel ke 1 pendaftaran siswa spesifik,
// bukan ke program secara umum. Perubahan itu nggak pernah direkam migration,
// jadi kalau `php artisan migrate` dijalanin di environment BARU (misal pas
// setup ulang / deploy dari nol), strukturnya bakal beda dari produksi.
//
// Migration ini nyamain: kalau masih ada `program_id` (environment baru/fresh),
// diganti jadi `pendaftaran_id`. Kalau di production (udah `pendaftaran_id`
// duluan), migration ini otomatis di-skip (aman, nggak ngubah apa-apa).
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('jadwal_kelas', 'program_id') && ! Schema::hasColumn('jadwal_kelas', 'pendaftaran_id')) {
            Schema::table('jadwal_kelas', function (Blueprint $table) {
                $table->dropForeign(['program_id']);
                $table->renameColumn('program_id', 'pendaftaran_id');
            });

            Schema::table('jadwal_kelas', function (Blueprint $table) {
                $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('jadwal_kelas', 'pendaftaran_id') && ! Schema::hasColumn('jadwal_kelas', 'program_id')) {
            Schema::table('jadwal_kelas', function (Blueprint $table) {
                $table->dropForeign(['pendaftaran_id']);
                $table->renameColumn('pendaftaran_id', 'program_id');
            });

            Schema::table('jadwal_kelas', function (Blueprint $table) {
                $table->foreign('program_id')->references('id')->on('program_kursus')->onDelete('cascade');
            });
        }
    }
};
