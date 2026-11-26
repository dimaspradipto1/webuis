<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PmbBrosur extends Model
{
    use HasFactory;

    protected $table = 'pmb_brosurs';

    protected $fillable = [
        'judul',
        'kategori_fakultas',
        'gambar',
        'nama_file_asli',
        'file_pdf',
        'nama_pdf_asli',
        'deskripsi',
        'tahun_akademik',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Pastikan tabel pmb_brosurs ada di database untuk mencegah error pada server live/cPanel
     */
    public static function ensureTableExists(): void
    {
        try {
            if (! Schema::hasTable('pmb_brosurs')) {
                Schema::create('pmb_brosurs', function (Blueprint $table) {
                    $table->id();
                    $table->string('judul');
                    $table->string('kategori_fakultas')->default('Universitas');
                    $table->string('gambar');
                    $table->string('nama_file_asli')->nullable();
                    $table->string('file_pdf')->nullable();
                    $table->string('nama_pdf_asli')->nullable();
                    $table->text('deskripsi')->nullable();
                    $table->string('tahun_akademik')->nullable()->default('2026/2027');
                    $table->integer('urutan')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            } else {
                if (! Schema::hasColumn('pmb_brosurs', 'nama_file_asli')) {
                    Schema::table('pmb_brosurs', function (Blueprint $table) {
                        $table->string('nama_file_asli')->nullable()->after('gambar');
                    });
                }
                if (! Schema::hasColumn('pmb_brosurs', 'nama_pdf_asli')) {
                    Schema::table('pmb_brosurs', function (Blueprint $table) {
                        $table->string('nama_pdf_asli')->nullable()->after('file_pdf');
                    });
                }
            }
        } catch (\Throwable $e) {
            // Fail silently
        }
    }

    /**
     * Accessor untuk URL Gambar Brosur
     */
    public function getGambarUrlAttribute(): string
    {
        if (empty($this->gambar)) {
            return asset('frontend/images/pmb/default-brosur.jpg');
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        return asset('storage/' . $this->gambar);
    }

    /**
     * Accessor untuk URL File PDF Brosur
     */
    public function getPdfUrlAttribute(): ?string
    {
        if (empty($this->file_pdf)) {
            return null;
        }

        if (str_starts_with($this->file_pdf, 'http://') || str_starts_with($this->file_pdf, 'https://')) {
            return $this->file_pdf;
        }

        return asset('storage/' . $this->file_pdf);
    }

    /**
     * Label Kategori / Fakultas yang rapi
     */
    public function getKategoriBadgeAttribute(): string
    {
        return match ($this->kategori_fakultas) {
            'Fakultas Sains dan Teknologi' => 'Sains & Teknologi',
            'Fakultas Ekonomi dan Bisnis' => 'Ekonomi & Bisnis',
            'Fakultas Ilmu Kesehatan' => 'Ilmu Kesehatan',
            'Program Pascasarjana' => 'Pascasarjana',
            default => 'Universitas',
        };
    }

    /**
     * Nama file original yang aman dan rapi untuk proses unduh (download)
     */
    public function getNamaDownloadAttribute(): string
    {
        $ext = pathinfo($this->gambar ?? '', PATHINFO_EXTENSION) ?: 'png';

        if (!empty($this->nama_file_asli) && !preg_match('/^[a-zA-Z0-9]{30,}\.[a-z]+$/', $this->nama_file_asli)) {
            $name = $this->nama_file_asli;
            $nameExt = pathinfo($name, PATHINFO_EXTENSION);
            if (empty($nameExt)) {
                $name .= '.' . $ext;
            }
            return $name;
        }

        // Jika nama_file_asli kosong atau hash bawaan, gunakan judul resmi brosur
        $base = !empty($this->judul) ? $this->judul : 'Brosur PMB UIS';
        return 'Brosur PMB - ' . $base . '.' . $ext;
    }

    /**
     * Nama file PDF original untuk proses unduh
     */
    public function getNamaPdfDownloadAttribute(): string
    {
        if (!empty($this->nama_pdf_asli) && !preg_match('/^[a-zA-Z0-9]{30,}\.pdf$/i', $this->nama_pdf_asli)) {
            $name = $this->nama_pdf_asli;
            $nameExt = pathinfo($name, PATHINFO_EXTENSION);
            if (empty($nameExt)) {
                $name .= '.pdf';
            }
            return $name;
        }

        $base = !empty($this->judul) ? $this->judul : 'Panduan Brosur PMB UIS';
        return 'Panduan - ' . $base . '.pdf';
    }
}
