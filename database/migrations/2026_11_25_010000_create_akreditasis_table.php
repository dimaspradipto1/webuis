<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akreditasis', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat', 30)->default('prodi'); // universitas, fakultas, prodi
            $table->string('kategori_label')->default('Institusi'); // Institusi, Fakultas ..., Program Pascasarjana
            $table->string('nama');
            $table->string('jenjang', 20)->nullable(); // Institusi, Fakultas, S1, S2
            $table->string('lembaga', 50)->default('BAN-PT'); // BAN-PT, LAM-INFOKOM, LAMEMBA, LAM-PTKes
            $table->string('peringkat', 50)->default('Baik Sekali'); // Unggul, Baik Sekali, Baik, A, B
            $table->string('nomor_sk')->nullable();
            $table->string('tahun_sk', 10)->nullable();
            $table->string('masa_berlaku')->nullable();
            $table->string('file_sertifikat')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akreditasis');
    }
};
