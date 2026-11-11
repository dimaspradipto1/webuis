<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;

class Sarana extends Model
{
    use HasVirtualSlug;

    protected $table = 'saranas';

    protected $fillable = [
        'icon',
        'nama',
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
