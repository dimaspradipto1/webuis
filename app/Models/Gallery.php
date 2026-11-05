<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'deskripsi',
        'url',
        'galeri',
    ];

    protected $casts = [
        'galeri' => 'array',
    ];

    /**
     * Boot model events to auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($gallery) {
            if (empty($gallery->slug) && ! empty($gallery->judul)) {
                $baseSlug = Str::slug($gallery->judul);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $gallery->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$count;
                    $count++;
                }

                $gallery->slug = $slug;
            }
        });
    }
}
