<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroHumas extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'hero_humas';

    protected $fillable = [
        'judul',
        'subjudul',
        'badge_text',
        'background_image',
        'pill_text_1',
        'pill_url_1',
        'pill_text_2',
        'pill_url_2',
        'pill_text_3',
        'pill_url_3',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get background image URL
     */
    public function getBackgroundImageUrlAttribute(): ?string
    {
        if ($this->background_image) {
            if (str_starts_with($this->background_image, 'http://') || str_starts_with($this->background_image, 'https://')) {
                return $this->background_image;
            }
            if (str_starts_with($this->background_image, 'assets/') || str_starts_with($this->background_image, 'frontend/')) {
                return asset($this->background_image);
            }

            return asset('storage/'.$this->background_image);
        }

        return null;
    }
}
