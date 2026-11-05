<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanAgenda extends Model
{
    protected $table = 'pengumuman_agendas';

    protected $fillable = [
        'tipe',
        'judul',
        'waktu',
        'url',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];
}

