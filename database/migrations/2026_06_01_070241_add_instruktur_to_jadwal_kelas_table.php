<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            // Nambahin kolom instruktur_id persis setelah program_id
            $table->foreignId('instruktur_id')->after('program_id')->constrained('instrukturs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->dropForeign(['instruktur_id']);
            $table->dropColumn('instruktur_id');
        });
    }
};
