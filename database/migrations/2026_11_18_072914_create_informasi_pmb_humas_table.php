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
        Schema::create('informasi_pmb_humas', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->default('Informasi Khusus Penerimaan Mahasiswa Baru');
            $table->string('subjudul')->nullable()->default('Tahun Akademik 2026/2027 — Universitas Ibnu Sina');
            $table->string('badge_text')->nullable()->default('PMB TA 2026/2027');
            $table->text('deskripsi_singkat')->nullable();
            $table->string('file_pdf')->nullable();
            $table->string('file_pdf_nama')->nullable();
            $table->string('gambar_brosur')->nullable();
            $table->string('gambar_brosur_2')->nullable();
            $table->string('link_pendaftaran')->nullable()->default('https://pmb.uis.ac.id');
            $table->string('no_wa_pmb')->nullable()->default('082283958644');
            $table->text('gelombang_info')->nullable();
            $table->text('persyaratan_info')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pmb_humas');
    }
};
