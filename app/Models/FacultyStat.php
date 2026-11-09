<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyStat extends Model
{
    protected $table = 'faculty_stats';

    protected $fillable = [
        'title',
        'image',
        'background_image',
        'jumlah_prodi',
        'total_mahasiswa',
        'total_dosen',
        'total_alumni',
        'is_active',

        // Tab 1: Mahasiswa
        'tab_1_label',
        'mhs_total',
        'mhs_total_label',
        'mhs_baru',
        'mhs_baru_label',
        'mhs_alumni',
        'mhs_alumni_label',

        // Tab 2: Prestasi
        'tab_2_label',
        'prestasi_nasional',
        'prestasi_nasional_label',
        'prestasi_provinsi',
        'prestasi_provinsi_label',
        'prestasi_internasional',
        'prestasi_internasional_label',

        // Tab 3: Kerjasama
        'tab_3_label',
        'kerjasama_total',
        'kerjasama_total_label',
        'kerjasama_perusahaan',
        'kerjasama_perusahaan_label',
        'kerjasama_pemerintahan',
        'kerjasama_pemerintahan_label',
        'kerjasama_sekolah',
        'kerjasama_sekolah_label',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'jumlah_prodi' => 'integer',
        'total_mahasiswa' => 'integer',
        'total_dosen' => 'integer',
        'total_alumni' => 'integer',
        'mhs_total' => 'integer',
        'mhs_baru' => 'integer',
        'mhs_alumni' => 'integer',
        'prestasi_nasional' => 'integer',
        'prestasi_provinsi' => 'integer',
        'prestasi_internasional' => 'integer',
        'kerjasama_total' => 'integer',
        'kerjasama_perusahaan' => 'integer',
        'kerjasama_pemerintahan' => 'integer',
        'kerjasama_sekolah' => 'integer',
    ];

    /**
     * Pastikan kata FIKES tidak tampil pada judul statistik universitas.
     */
    public function getTitleAttribute(?string $value): string
    {
        $cleaned = trim((string) preg_replace('/\bFIKES\b\s*/i', '', $value ?? ''));

        return $cleaned !== '' ? $cleaned : 'UIS Dalam Angka';
    }

    /**
     * Dapatkan background image url
     */
    public function getBgImageUrlAttribute(): string
    {
        if ($this->background_image) {
            if (file_exists(public_path($this->background_image))) {
                return asset($this->background_image);
            }

            return asset('storage/'.$this->background_image);
        }

        return asset('frontend/img/gedung-uis.jpg');
    }
}
