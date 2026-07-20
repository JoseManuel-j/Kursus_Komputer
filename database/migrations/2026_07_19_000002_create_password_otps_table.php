<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel buat nyimpen kode OTP lupa password. Dipisah dari
        // password_reset_tokens (bawaan Laravel, sistemnya link bukan OTP)
        // karena flow kita beda: siswa masukin kode 6 digit, bukan klik link.
        Schema::create('password_otps', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp', 6);
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_otps');
    }
};
