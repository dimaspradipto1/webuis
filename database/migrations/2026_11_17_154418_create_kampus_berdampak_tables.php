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
        Schema::create('kampus_berdampaks', function (Blueprint $table) {
            $table->id();
            $table->string('judul_section')->default('Tentang Kampus Berdampak');
            $table->string('tagline')->nullable()->default('Menciptakan Perubahan Nyata untuk Masa Depan');
            $table->text('deskripsi')->nullable();
            $table->string('poster')->nullable();
            $table->string('file_panduan')->nullable();
            $table->string('file_panduan_url')->nullable();
            $table->string('tombol_teks')->default('Download Panduan MBKM');
            $table->string('badge_status')->default('AKTIF 2024');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('kampus_berdampak_programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('kampus_berdampak_programs');
        Schema::dropIfExists('kampus_berdampaks');
    }
};
