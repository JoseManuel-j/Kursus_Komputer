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