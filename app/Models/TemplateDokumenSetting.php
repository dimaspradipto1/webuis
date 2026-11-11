<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDokumenSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'template_dokumen_settings';

    protected $fillable = [
        'judul_seksi',
        'deskripsi_seksi',
    ];
}
