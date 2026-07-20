<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('instrukturs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_telepon');
            $table->string('email')->unique(); // Buat username login
            $table->string('password'); // Buat password login
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrukturs');
    }
};
