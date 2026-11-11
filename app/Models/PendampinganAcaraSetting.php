<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendampinganAcaraSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'pendampingan_acara_settings';

    protected $fillable = [
        'judul_hero',
        'subjudul_hero',
        'judul_seksi',
        'sapaan',
        'konten',
        'paragraf_1',
        'paragraf_2',
        'poin_bantuan',
        'paragraf_3',
        'link_form',
        'tombol_teks',
        'no_wa',
        'file_sop',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
