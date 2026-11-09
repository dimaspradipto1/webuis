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
        Schema::create('faculty_stats', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('UIS Dalam Angka');
            $table->string('image')->nullable()->comment('Path gambar gedung/kampus (opsional)');
            $table->unsignedSmallInteger('jumlah_prodi')->default(0)->comment('Jumlah Program Studi');
            $table->unsignedInteger('total_mahasiswa')->default(0)->comment('Total Mahasiswa Aktif');
            $table->unsignedSmallInteger('total_dosen')->default(0)->comment('Total Dosen');
            $table->unsignedInteger('total_alumni')->default(0)->comment('Total Alumni');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_stats');
    }
};
