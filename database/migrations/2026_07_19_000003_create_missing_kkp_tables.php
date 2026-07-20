<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel-tabel ini SUDAH ADA di database produksi (dibuat manual lewat
// phpMyAdmin, sesuai SQL dump yang dikasih Yos), tapi belum pernah punya
// migration Laravel. Makanya tiap Schema::create() di bawah dibungkus
// `if (! Schema::hasTable(...))` — supaya:
//  - Di server produksi (tabelnya udah ada): migration ini di-skip, aman,
//    nggak nimpa data yang udah ada.
//  - Di environment baru / testing (tabel belum ada): tabel beneran dibuat
//    sama persis strukturnya kayak yang di produksi.
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('username', 100);
                $table->string('password');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('info_kursus')) {
            Schema::create('info_kursus', function (Blueprint $table) {
                $table->id();
                $table->string('nama_tempat');
                $table->text('alamat');
                $table->string('nomor_telepon', 20);
                $table->string('jam_operasional', 100);
                $table->string('hero_judul');
                $table->text('hero_deskripsi');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('foto_kegiatan')) {
            Schema::create('foto_kegiatan', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('keterangan')->nullable();
                $table->string('nama_file');
                $table->integer('urutan')->default(0);
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('absensi')) {
            Schema::create('absensi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pendaftaran_id');
                $table->unsignedBigInteger('jadwal_id');
                $table->date('tanggal');
                $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
                $table->text('keterangan')->nullable();
                $table->timestamps();

                $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
                $table->foreign('jadwal_id')->references('id')->on('jadwal_kelas')->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('transaksi_pembayaran')) {
            Schema::create('transaksi_pembayaran', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pendaftaran_id');
                $table->decimal('jumlah_bayar', 10, 0);
                $table->string('no_bukti', 50);
                $table->date('tgl_bayar');
                $table->string('bukti_transfer');
                $table->string('keterangan');
                $table->timestamps();

                $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('riwayat_aktivitas')) {
            Schema::create('riwayat_aktivitas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('keterangan');
                $table->string('kursus');
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_aktivitas');
        Schema::dropIfExists('transaksi_pembayaran');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('foto_kegiatan');
        Schema::dropIfExists('info_kursus');
        Schema::dropIfExists('admins');
    }
};
