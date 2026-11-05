<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengumuman_agendas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['pengumuman', 'agenda'])->default('pengumuman');
            $table->string('judul');
            $table->string('waktu')->nullable(); // Tanggal pengumuman atau rentang waktu agenda
            $table->string('url', 1000)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('pengumuman_agendas')->insert([
            [
                'tipe' => 'pengumuman',
                'judul' => 'Pengumuman Pengisian KRS dan validasi KRS Tahun Akademik 2026/2027 Gasal',
                'waktu' => '15 August 2026',
                'url' => null,
                'urutan' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe' => 'pengumuman',
                'judul' => 'Pengumuman Semester Antara TA. 2025-2026',
                'waktu' => '1 August 2026',
                'url' => null,
                'urutan' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe' => 'agenda',
                'judul' => 'Pendaftaran Semester Antara',
                'waktu' => '20 - 31 Juli 2026',
                'url' => null,
                'urutan' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe' => 'agenda',
                'judul' => 'Perkuliahan Semester Antara',
                'waktu' => '03 - 28 Agustus 2026',
                'url' => null,
                'urutan' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe' => 'agenda',
                'judul' => 'Penyerahan Nilai Semester Antara',
                'waktu' => '31 Agustus - 05 September 2026',
                'url' => null,
                'urutan' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman_agendas');
    }
};

