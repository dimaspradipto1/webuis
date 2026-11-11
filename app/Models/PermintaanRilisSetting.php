<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanRilisSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'permintaan_rilis_settings';

    protected $fillable = [
        'judul_hero',
        'subjudul_hero',
        'badge_label',
        'judul_seksi',
        'deskripsi_seksi',
        'link_form',
        'no_wa',
        'email_tujuan',
        'file_sop',
        'min_kata',
        'min_paragraf',
        'catatan_tambahan',
        'is_active',
    ];

    protected $casts = [
        'min_kata' => 'integer',
        'min_paragraf' => 'integer',
        'is_active' => 'boolean',
    ];
}
