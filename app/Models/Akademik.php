<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akademik extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'akademiks';

    protected $fillable = [
        'tipe',
        'judul',
        'subjudul',
        'deskripsi',
        'file_dokumen',
        'file_nama',
        'link_url',
        'gambar',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
