<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KampusBerdampak extends Model
{
    use HasFactory;

    protected $table = 'kampus_berdampaks';

    protected $fillable = [
        'judul_section',
        'tagline',
        'deskripsi',
        'poster',
        'file_panduan',
        'file_panduan_url',
        'tombol_teks',
        'badge_status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
