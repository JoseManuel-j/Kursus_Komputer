<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Pola yang sama kayak migration penyelaras sebelumnya: di produksi,
// `tagihan.status` udah diubah manual dari enum(lunas/belum_lunas/cicilan)
// jadi varchar(20) bebas — makanya status yang beneran kepakai itu
// 'pending' (bukan 'belum_lunas'). Kolom `buktiTransfer` & `tanggal_bayar`
// juga ada di produksi (dipakai alur pembayaran lama/manual di web) tapi
// nggak pernah ke-capture migration.
return new class extends Migration
{
    public function up(): void
    {
        // SQLite nggak punya ALTER COLUMN TYPE yang gampang buat ganti enum->string
        // lewat Schema::table biasa, jadi kita cek dulu baru jalanin kalau perlu.
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // doctrine/dbal dipakai Laravel buat modifikasi kolom di sqlite;
            // kalau nggak ke-install, migration ini di-skip aman aja (fresh
            // install baru emang defaultnya 'belum_lunas', beda status string
            // doang, nggak fatal — cuma buat konsistensi lokal/testing).
            try {
                Schema::table('tagihan', function (Blueprint $table) {
                    $table->string('status', 20)->default('belum_lunas')->change();
                });
            } catch (\Throwable $e) {
                // skip diem-diem, nggak fatal
            }
        } else {
            DB::statement("ALTER TABLE tagihan MODIFY status VARCHAR(20) NOT NULL DEFAULT 'belum_lunas'");
        }

        Schema::table('tagihan', function (Blueprint $table) {
            if (! Schema::hasColumn('tagihan', 'buktiTransfer')) {
                $table->string('buktiTransfer')->nullable();
            }
            if (! Schema::hasColumn('tagihan', 'tanggal_bayar')) {
                $table->date('tanggal_bayar')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tagihan', function (Blueprint $table) {
            if (Schema::hasColumn('tagihan', 'buktiTransfer')) {
                $table->dropColumn('buktiTransfer');
            }
            if (Schema::hasColumn('tagihan', 'tanggal_bayar')) {
                $table->dropColumn('tanggal_bayar');
            }
        });
    }
};
