<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesainGrafisSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'desain_grafis_settings';

    protected $fillable = [
        'hero_title',
        'hero_highlight',
        'hero_subtitle',
        'order_box_title',
        'order_box_text',
        'order_box_btn_text',
        'order_box_wa_url',
        'track_bar_text',
        'stat_total',
        'stat_selesai',
        'stat_dikerjakan',
        'stat_menunggu',
        'guide_title',
        'guide_steps',
        'guide_image',
    ];

    protected $casts = [
        'stat_total' => 'integer',
        'stat_selesai' => 'integer',
        'stat_dikerjakan' => 'integer',
        'stat_menunggu' => 'integer',
    ];

    /**
     * Dapatkan URL Gambar Panduan
     */
    public function getGuideImageUrlAttribute(): ?string
    {
        if ($this->guide_image) {
            return asset('storage/'.$this->guide_image);
        }

        return null;
    }
}
