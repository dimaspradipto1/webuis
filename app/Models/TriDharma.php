<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriDharma extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'tri_dharmas';

    protected $fillable = [
        'icon',
        'warna',
        'judul',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];
}
