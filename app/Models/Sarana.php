<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sarana extends Model
{
    protected $table = 'saranas';

    protected $fillable = [
        'icon',
        'nama',
        'slug',
        'kategori',
        'deskripsi',
        'foto',
        'galeri',
        'konten_detail',
        'lokasi',
        'kapasitas',
        'jam_operasional',
        'penanggung_jawab',
        'spesifikasi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'galeri' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Sarana $sarana) {
            if (! empty($sarana->deskripsi)) {
                $sarana->deskripsi = trim(html_entity_decode(strip_tags($sarana->deskripsi), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }
            if (empty($sarana->slug) || $sarana->isDirty('nama')) {
                $baseSlug = Str::slug($sarana->nama) ?: 'fasilitas';
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $sarana->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$counter++;
                }
                $sarana->slug = $slug;
            }
        });
    }

    /**
     * Scope: hanya data aktif, urut tampil.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
