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
        if (! Schema::hasTable('pmb_brosurs')) {
            Schema::create('pmb_brosurs', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('kategori_fakultas')->default('Universitas');
                $table->string('gambar');
                $table->string('file_pdf')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('tahun_akademik')->nullable()->default('2026/2027');
                $table->integer('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Migrasikan poster brosur yang sudah diunggah sebelumnya di informasi_pmb_humas jika ada
        if (Schema::hasTable('informasi_pmb_humas') && Schema::hasTable('pmb_brosurs')) {
            $existingPmb = DB::table('informasi_pmb_humas')->first();
            if ($existingPmb && ! empty($existingPmb->gambar_brosur)) {
                $count = DB::table('pmb_brosurs')->count();
                if ($count === 0) {
                    DB::table('pmb_brosurs')->insert([
                        'judul' => 'Brosur Utama Penerimaan Mahasiswa Baru',
                        'kategori_fakultas' => 'Universitas',
                        'gambar' => $existingPmb->gambar_brosur,
                        'file_pdf' => $existingPmb->file_pdf ?? null,
                        'deskripsi' => 'Menampilkan jalur penerimaan, keunggulan kampus, pilihan fakultas, fasilitas, serta informasi kontak resmi panitia PMB UIS.',
                        'tahun_akademik' => '2026/2027',
                        'urutan' => 1,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    if (! empty($existingPmb->gambar_brosur_2)) {
                        DB::table('pmb_brosurs')->insert([
                            'judul' => 'Brosur Alur & Rincian Biaya Kuliah',
                            'kategori_fakultas' => 'Universitas',
                            'gambar' => $existingPmb->gambar_brosur_2,
                            'file_pdf' => null,
                            'deskripsi' => 'Rincian panduan langkah pendaftaran online dan skema pembiayaan kuliah terjangkau.',
                            'tahun_akademik' => '2026/2027',
                            'urutan' => 2,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmb_brosurs');
    }
};
