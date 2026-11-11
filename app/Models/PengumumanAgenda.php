<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;

class PengumumanAgenda extends Model
{
    use HasVirtualSlug;

    protected $table = 'pengumuman_agendas';

    protected $fillable = [
        'tipe',
        'judul',
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
}
