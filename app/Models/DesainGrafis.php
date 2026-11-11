<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesainGrafis extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'desain_grafis';

    protected $fillable = [
        'judul',
        'kategori',
        'badge_teks',
        'spesifikasi',
        'deskripsi',
        'canva_url',
        'gambar_preview',
        'warna_gradient',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Dapatkan label kategori yang rapi
     */
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'audit' => 'Auditorium lt. 4 Rektorat',
            'sidang' => 'Ruang Sidang lt. 2 Rektorat',
            'dekanat' => 'Ruang Rapat Dekanat',
            'spanduk' => 'Banner & Spanduk Outdoor',
            default => ucfirst($this->kategori ?? 'Lainnya'),
        };
    }

    /**
     * Dapatkan URL Gambar Preview atau Gradient
     */
    public function getPreviewUrlAttribute(): ?string
    {
        if ($this->gambar_preview) {
            return asset('storage/'.$this->gambar_preview);
        }

        return null;
    }
}
