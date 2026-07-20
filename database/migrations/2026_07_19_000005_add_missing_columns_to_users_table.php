<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Sama kayak migration jadwal_kelas sebelumnya: kolom-kolom ini SUDAH ADA di
// database produksi (ditambah manual lewat phpMyAdmin) tapi nggak pernah
// direkam migration apapun. Ditambahin di sini (dengan hasColumn guard)
// biar environment baru/fresh strukturnya sama persis kayak produksi.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('password');
            }
            if (! Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (! Schema::hasColumn('users', 'agama')) {
                $table->string('agama', 100)->nullable()->after('tanggal_lahir');
            }
            if (! Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('agama');
            }
            if (! Schema::hasColumn('users', 'nomor_hp')) {
                $table->string('nomor_hp', 20)->nullable()->after('alamat');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['siswa', 'admin', 'instruktur'])->default('siswa')->after('nomor_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'nomor_hp', 'role'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
