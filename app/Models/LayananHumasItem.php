<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananHumasItem extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'layanan_humas_items';

    protected $fillable = [
        'kode',
        'nama',
        'icon',
        'badge_text',
        'deskripsi',
        'url',
        'file_path',
        'target_blank',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'target_blank' => 'boolean',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Dapatkan link tujuan aktif untuk frontend
     */
    public function getTargetUrlAttribute(): string
    {
        if ($this->file_path) {
            return asset('storage/'.$this->file_path);
        }

        if (! empty($this->url)) {
            return $this->url;
        }

        return match ($this->kode) {
            'unduhan' => route('homepage.unduhan'),
            'desain-grafis' => route('homepage.desain-grafis'),
            'galeri-kegiatan' => route('homepage.galeri.humas'),
            'template-dokumen' => route('homepage.template-dokumen'),
            'permintaan-rilis' => route('homepage.permintaan-rilis'),
            'pendampingan-acara' => route('homepage.pendampingan-acara'),
            'survey-layanan' => route('homepage.survey-layanan'),
            'panduan-desain' => route('homepage.desain-grafis'),
            default => '#',
        };
    }

    /**
     * Scope item aktif terurut
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
