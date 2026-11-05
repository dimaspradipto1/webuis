<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PengumumanAgenda extends Model
{
    protected $table = 'pengumuman_agendas';

    protected $fillable = [
        'tipe',
        'judul',
        'slug',
        'waktu',
        'konten',
        'lokasi',
        'foto',
        'galeri',
        'file_lampiran',
        'url',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'galeri' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug) && ! empty($model->judul)) {
                $baseSlug = Str::slug($model->judul);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $model->id ?? 0)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }

                $model->slug = $slug;
            }
        });
    }
}
