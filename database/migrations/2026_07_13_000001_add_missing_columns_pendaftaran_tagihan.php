<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom ini sudah dipakai di PendaftaranController@store tapi belum ada
        // di migration awal, jadi proses daftar+bayar selalu gagal (kolom nggak ketemu).
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('file_ktp')->nullable()->after('status');
            $table->string('file_ijazah')->nullable()->after('file_ktp');
            $table->string('pas_foto')->nullable()->after('file_ijazah');
        });

        Schema::table('tagihan', function (Blueprint $table) {
            $table->string('buktiTransfer')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['file_ktp', 'file_ijazah', 'pas_foto']);
        });

        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropColumn('buktiTransfer');
        });
    }
};
