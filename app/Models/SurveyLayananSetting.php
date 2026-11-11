<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyLayananSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'survey_layanan_settings';

    protected $fillable = [
        'judul_hero',
        'subjudul_hero',
        'judul_seksi',
        'deskripsi_seksi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
