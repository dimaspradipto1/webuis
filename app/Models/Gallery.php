<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasVirtualSlug;

    protected $table = 'galleries';

    protected $fillable = [
        'news_id',
        'judul',
        'kategori',
        'kategori_berita',
        'deskripsi',
        'url',
        'galeri',
    ];

    protected $casts = [
        'galeri' => 'array',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery) {
            if (! empty($gallery->deskripsi)) {
                $gallery->deskripsi = trim(html_entity_decode(strip_tags($gallery->deskripsi), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }
        });
    }
}
