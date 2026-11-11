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
}
