<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmagazineHumas extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'emagazine_humas';

    protected $fillable = [
        'judul_seksi',
        'is_active',

        // Tab 1: E-Magazine
        'tab_1_label',
        'tab_1_badge_text',
        'tab_1_cover_image',
        'tab_1_judul',
        'tab_1_deskripsi',
        'tab_1_btn_preview_text',
        'tab_1_btn_preview_url',
        'tab_1_btn_download_text',
        'tab_1_file_download',
        'tab_1_download_url',

        // Tab 2: Buku Saku
        'tab_2_label',
        'tab_2_badge_text',
        'tab_2_cover_image',
        'tab_2_judul',
        'tab_2_deskripsi',
        'tab_2_btn_preview_text',
        'tab_2_btn_preview_url',
        'tab_2_btn_download_text',
        'tab_2_file_download',
        'tab_2_download_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Dapatkan URL file download Tab 1
     */
    public function getTab1DownloadLinkAttribute(): string
    {
        if ($this->tab_1_file_download) {
            return asset('storage/'.$this->tab_1_file_download);
        }

        return $this->tab_1_download_url ?: '#';
    }

    /**
     * Dapatkan URL file download Tab 2
     */
    public function getTab2DownloadLinkAttribute(): string
    {
        if ($this->tab_2_file_download) {
            return asset('storage/'.$this->tab_2_file_download);
        }

        return $this->tab_2_download_url ?: '#';
    }
}
