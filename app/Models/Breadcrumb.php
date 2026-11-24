<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
    use HasFactory;

    protected $table = 'breadcrumbs';

    protected $fillable = [
        'page_key',
        'menu_name',
        'kategori_menu',
        'badge_text',
        'judul',
        'subjudul',
        'breadcrumb_item_1',
        'breadcrumb_url_1',
        'breadcrumb_item_2',
        'breadcrumb_url_2',
        'breadcrumb_active',
        'background_image',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Cache or quick lookup for a page by page_key
     */
    public static function getForPage(string $key): ?self
    {
        static $cached = [];
        if (!isset($cached[$key])) {
            $cached[$key] = static::where('page_key', $key)->first();
        }
        return $cached[$key];
    }

    /**
     * Accessor for full background image URL
     */
    public function getBgImageUrlAttribute(): ?string
    {
        if (!empty($this->background_image)) {
            if (filter_var($this->background_image, FILTER_VALIDATE_URL)) {
                return $this->background_image;
            }
            if (file_exists(public_path('storage/' . $this->background_image))) {
                return asset('storage/' . $this->background_image);
            }
            if (file_exists(public_path($this->background_image))) {
                return asset($this->background_image);
            }
        }
        return null;
    }
}
