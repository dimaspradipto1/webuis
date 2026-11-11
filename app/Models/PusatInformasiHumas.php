<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PusatInformasiHumas extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'pusat_informasi_humas';

    protected $fillable = [
        'judul',
        'gambar',
        'link_drive',
        'button_text',
        'button_url',
        'target_blank',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'target_blank' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Konversi link sharing Google Drive menjadi link gambar direct stream CDN
     */
    public static function formatGoogleDriveUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $cleanUrl = trim($url);

        // Ekstrak ID Google Drive (file/d/ID atau id=ID atau open?id=ID)
        if (preg_match('/(?:drive\.google\.com\/(?:file\/d\/|open\?id=)|id=)([a-zA-Z0-9_-]{25,})/i', $cleanUrl, $matches)) {
            return 'https://lh3.googleusercontent.com/d/'.$matches[1];
        }

        return $cleanUrl;
    }

    /**
     * Get image URL (uploaded image or Google Drive / external URL)
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->gambar) {
            if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
                return static::formatGoogleDriveUrl($this->gambar);
            }
            if (str_starts_with($this->gambar, 'assets/') || str_starts_with($this->gambar, 'frontend/')) {
                return asset($this->gambar);
            }

            return asset('storage/'.$this->gambar);
        }

        if ($this->link_drive) {
            return static::formatGoogleDriveUrl($this->link_drive);
        }

        return null;
    }

    /**
     * Scope for active items ordered by urutan
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
