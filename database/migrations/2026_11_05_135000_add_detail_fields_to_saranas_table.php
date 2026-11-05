<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('saranas', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('nama');
            $table->string('kategori', 100)->default('Fasilitas Kampus')->after('slug');
            $table->string('foto')->nullable()->after('deskripsi');
            $table->json('galeri')->nullable()->after('foto');
            $table->longText('konten_detail')->nullable()->after('galeri');
            $table->string('lokasi')->nullable()->after('konten_detail');
            $table->string('kapasitas', 150)->nullable()->after('lokasi');
            $table->string('jam_operasional', 150)->nullable()->after('kapasitas');
            $table->string('penanggung_jawab', 150)->nullable()->after('jam_operasional');
            $table->text('spesifikasi')->nullable()->after('penanggung_jawab');
        });

        $saranas = DB::table('saranas')->get();
        foreach ($saranas as $sarana) {
            $slug = Str::slug($sarana->nama) ?: ('fasilitas-'.$sarana->id);
            $isLab = str_contains(strtolower($sarana->nama), 'lab') || str_contains(strtolower($sarana->nama), 'studio');

            DB::table('saranas')->where('id', $sarana->id)->update([
                'slug' => $slug,
                'kategori' => $isLab ? 'Laboratorium & Studio' : 'Fasilitas Kampus',
                'lokasi' => 'Kampus Terpadu Universitas Ibnu Sina, Lubuk Baja, Batam',
                'kapasitas' => $isLab ? '40 Mahasiswa / Sesi Praktikum' : '100 - 300 Civitas Akademika',
                'jam_operasional' => 'Senin – Sabtu, 08.00 – 21.00 WIB',
                'penanggung_jawab' => $isLab ? 'Kepala Laboratorium Terpadu UIS' : 'Biro Administrasi Umum & Fasilitas UIS',
                'konten_detail' => '<p><strong>'.e($sarana->nama).'</strong> merupakan salah satu sarana unggulan di lingkungan Universitas Ibnu Sina (UIS) Batam yang dirancang untuk mendukung proses pembelajaran, praktikum terpadu, serta kegiatan riset dosen dan mahasiswa secara optimal.</p><p>'.e($sarana->deskripsi ?? '').' Seluruh perangkat dan infrastruktur pada fasilitas ini dikelola secara berkala sesuai standar mutu pendidikan tinggi nasional guna menjamin kenyamanan, keselamatan kerja, dan efektivitas kegiatan akademik.</p>',
                'spesifikasi' => "Ruangan ber-AC penuh dan pencahayaan standar akademik\nKoneksi internet serat optik berkecepatan tinggi (Wi-Fi Kampus)\nPerangkat multimedia dan proyektor interaktif\nSistem keamanan CCTV 24 jam & prosedur K3 laboratorium",
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saranas', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'kategori',
                'foto',
                'galeri',
                'konten_detail',
                'lokasi',
                'kapasitas',
                'jam_operasional',
                'penanggung_jawab',
                'spesifikasi',
            ]);
        });
    }
};

