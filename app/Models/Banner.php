<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'banners';

    protected $fillable = [
        'judul',
        'url',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
