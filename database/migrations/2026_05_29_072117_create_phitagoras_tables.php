<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Admins
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->timestamps();
        });

        // 2. Tabel Info Kursus
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

        // 3. Tabel Foto Kegiatan
        Schema::create('foto_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('keterangan')->nullable();
            $table->string('nama_file');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // 4. Tabel Program Kursus 
        Schema::create('program_kursus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->enum('tipe_kelas', ['reguler', 'private'])->default('reguler');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_sesi'); // <--- INI YANG DIGANTI
            $table->decimal('biaya', 10, 2);
            $table->timestamps();
        });

        // 5. Tabel Pendaftaran
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('program_kursus')->onDelete('cascade');
            $table->date('tanggal_daftar');
            $table->enum('status', ['aktif', 'selesai', 'berhenti'])->default('aktif');
            $table->timestamps();
        });

        // 6. Tabel Jadwal Kelas
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_kursus')->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan', 100);
            $table->timestamps();
        });

        // 7. Tabel Absensi
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwal_kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 8. Tabel Tagihan
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->decimal('jumlah', 10, 2);
            $table->date('jatuh_tempo');
            $table->enum('status', ['lunas', 'belum_lunas', 'cicilan'])->default('belum_lunas');
            $table->timestamps();
        });

        // 9. Tabel Pembayaran
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihan')->onDelete('cascade');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->dateTime('tanggal_bayar');
            $table->string('metode', 100);
            $table->string('bukti_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('tagihan');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('jadwal_kelas');
        Schema::dropIfExists('pendaftaran');
        Schema::dropIfExists('program_kursus');
        Schema::dropIfExists('foto_kegiatan');
        Schema::dropIfExists('info_kursus');
        Schema::dropIfExists('admins');
    }
};