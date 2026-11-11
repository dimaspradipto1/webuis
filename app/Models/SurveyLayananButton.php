<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyLayananButton extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'survey_layanan_buttons';

    protected $fillable = [
        'judul',
        'link_url',
        'tombol_teks',
        'target_blank',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'target_blank' => 'boolean',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Dapatkan link_url yang terformat dengan protokol valid
     */
    public function getFormattedUrlAttribute(): string
    {
        $url = trim($this->link_url ?? '');
        if (! empty($url) && ! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://') && ! str_starts_with($url, '/') && ! str_starts_with($url, '#')) {
            return 'https://'.$url;
        }

        return $url ?: '#';
    }
}
