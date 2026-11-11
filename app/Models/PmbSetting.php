<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmbSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'pmb_settings';

    protected $fillable = [
        'badge_text',
        'judul',
        'deskripsi',
        'tombol_text_1',
        'tombol_link_1',
        'tombol_text_2',
        'tombol_link_2',
        'gelombang_list',
        'gelombang_1',
        'gelombang_2',
        'gelombang_3',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gelombang_list' => 'array',
    ];

    /**
     * Get list of waves with fallback to legacy fields.
     */
    public function getWavesAttribute(): array
    {
        if (! empty($this->gelombang_list) && is_array($this->gelombang_list)) {
            return array_values(array_filter($this->gelombang_list, fn ($item) => ! empty(trim($item ?? ''))));
        }

        $fallback = array_filter([
            $this->gelombang_1,
            $this->gelombang_2,
            $this->gelombang_3,
        ]);

        return ! empty($fallback) ? array_values($fallback) : [
            'Gelombang 1: Jan - Apr',
            'Gelombang 2: Mei - Jul',
            'Gelombang 3: Agu - Sep',
        ];
    }
}
