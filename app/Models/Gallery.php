<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasVirtualSlug;

    protected $table = 'galleries';

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'url',
        'galeri',
    ];

    protected $casts = [
        'galeri' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery) {
            if (! empty($gallery->deskripsi)) {
                $gallery->deskripsi = trim(html_entity_decode(strip_tags($gallery->deskripsi), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }
        });
    }
}
