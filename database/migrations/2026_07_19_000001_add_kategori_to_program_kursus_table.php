<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Kolom ini yang bedain "Program Paket" (kelas gabungan/kurikulum lengkap,
    // contoh: Adm Perk. Dasar, Graphic Design, dll) vs "Program Satuan"
    // (per-materi, contoh: Microsoft Word doang, Corel Draw doang, dll).
    // Sebelumnya pembeda paket/satuan cuma ada di komentar seeder & tampilan,
    // TIDAK ada di database -> makanya nggak bisa dipakai buat validasi
    // (misal: cicilan cuma boleh utk program paket).
    public function up(): void
    {
        Schema::table('program_kursus', function (Blueprint $table) {
            $table->enum('kategori', ['paket', 'satuan'])
                ->default('satuan')
                ->after('tipe_kelas');
        });

        // Auto-isi data yang sudah ada berdasarkan nama program bawaan seeder.
        // 5 program "paket" bawaan LPK Phitagoras:
        $namaPaket = [
            'Adm Perk. Dasar',
            'Adm Perk. Lanjutan',
            'Practical Office (Intensif)',
            'Graphic Design',
            'Technical Support',
        ];

        DB::table('program_kursus')
            ->whereIn('nama_program', $namaPaket)
            ->update(['kategori' => 'paket']);

        // Sisanya (Microsoft Word, Excel, Corel Draw, dst — reguler maupun private)
        // tetap default 'satuan', jadi nggak perlu di-update manual.
    }

    public function down(): void
    {
        Schema::table('program_kursus', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
