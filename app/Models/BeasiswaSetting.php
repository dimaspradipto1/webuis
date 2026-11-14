<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeasiswaSetting extends Model
{
    use HasFactory;

    protected $table = 'beasiswa_settings';

    protected $fillable = [
        'hero_badge',
        'hero_judul',
        'hero_deskripsi',
        'tentang_judul',
        'tentang_deskripsi',
        'gambar',
        'link_daftar',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
