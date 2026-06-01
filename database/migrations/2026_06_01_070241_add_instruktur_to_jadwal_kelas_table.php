public function up()
{
    Schema::table('jadwal_kelas', function (Blueprint $table) {
        // Nambahin kolom instruktur_id persis setelah program_id
        $table->foreignId('instruktur_id')->after('program_id')->constrained('instrukturs')->onDelete('cascade');
    });
}