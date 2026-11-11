<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'template_dokumens';

    protected $fillable = [
        'judul',
        'tipe_file',
        'link_drive',
        'icon_preset',
        'custom_icon',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Scope untuk item aktif terurut
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    /**
     * Dapatkan SVG Icon sesuai icon_preset (Presisi tinggi persis Image 2)
     */
    public function getIconHtmlAttribute(): string
    {
        if ($this->custom_icon) {
            return '<img src="'.asset('storage/'.$this->custom_icon).'" alt="'.e($this->judul).'" style="max-width: 140px; max-height: 150px; object-fit: contain;">';
        }

        return match ($this->icon_preset) {
            'powerpoint' => '<svg viewBox="0 0 110 140" style="width: 110px; height: 140px;" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="foldGradP" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#1e582e"/>
                                        <stop offset="100%" stop-color="#2a723d"/>
                                    </linearGradient>
                                </defs>
                                <!-- File Body -->
                                <path d="M14 0 C6.3 0 0 6.3 0 14 L0 126 C0 133.7 6.3 140 14 140 L96 140 C103.7 140 110 133.7 110 126 L110 38 L72 0 Z" fill="#357a44"/>
                                <!-- Fold Corner -->
                                <path d="M72 0 L110 38 L84 38 C77.4 38 72 32.6 72 26 Z" fill="url(#foldGradP)" opacity="0.85"/>
                                <!-- Bold P -->
                                <text x="52" y="98" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif" font-weight="900" font-size="64" text-anchor="middle">P</text>
                             </svg>',
            'idcard' => '<svg viewBox="0 0 160 115" style="width: 150px; height: 115px;" xmlns="http://www.w3.org/2000/svg">
                                <!-- Card Outline/Base -->
                                <rect x="0" y="0" width="160" height="115" rx="18" fill="#357a44"/>
                                <!-- Top Stripe Header -->
                                <path d="M0 18 C0 8 8 0 18 0 L142 0 C152 0 160 8 160 18 L160 26 L0 26 Z" fill="#296436"/>
                                <!-- Avatar Head -->
                                <circle cx="48" cy="56" r="18" fill="#ffffff"/>
                                <!-- Avatar Body -->
                                <path d="M22 98 C22 80 34 76 48 76 C62 76 74 80 74 98 Z" fill="#ffffff"/>
                                <!-- Text Bars -->
                                <rect x="90" y="44" width="48" height="9" rx="4.5" fill="#ffffff"/>
                                <rect x="90" y="62" width="48" height="9" rx="4.5" fill="#ffffff"/>
                                <rect x="90" y="80" width="34" height="9" rx="4.5" fill="#ffffff"/>
                             </svg>',
            'excel' => '<svg viewBox="0 0 110 140" style="width: 110px; height: 140px;" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 0 C6.3 0 0 6.3 0 14 L0 126 C0 133.7 6.3 140 14 140 L96 140 C103.7 140 110 133.7 110 126 L110 38 L72 0 Z" fill="#357a44"/>
                                <path d="M72 0 L110 38 L84 38 C77.4 38 72 32.6 72 26 Z" fill="#1e582e" opacity="0.85"/>
                                <text x="52" y="98" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif" font-weight="900" font-size="64" text-anchor="middle">X</text>
                             </svg>',
            'pdf' => '<svg viewBox="0 0 110 140" style="width: 110px; height: 140px;" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 0 C6.3 0 0 6.3 0 14 L0 126 C0 133.7 6.3 140 14 140 L96 140 C103.7 140 110 133.7 110 126 L110 38 L72 0 Z" fill="#357a44"/>
                                <path d="M72 0 L110 38 L84 38 C77.4 38 72 32.6 72 26 Z" fill="#1e582e" opacity="0.85"/>
                                <text x="52" y="90" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif" font-weight="900" font-size="34" text-anchor="middle">PDF</text>
                             </svg>',
            default => '<svg viewBox="0 0 110 140" style="width: 110px; height: 140px;" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="foldGradW" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#1e582e"/>
                                        <stop offset="100%" stop-color="#2a723d"/>
                                    </linearGradient>
                                </defs>
                                <!-- File Body -->
                                <path d="M14 0 C6.3 0 0 6.3 0 14 L0 126 C0 133.7 6.3 140 14 140 L96 140 C103.7 140 110 133.7 110 126 L110 38 L72 0 Z" fill="#357a44"/>
                                <!-- Fold Corner -->
                                <path d="M72 0 L110 38 L84 38 C77.4 38 72 32.6 72 26 Z" fill="url(#foldGradW)" opacity="0.85"/>
                                <!-- Bold W -->
                                <text x="52" y="96" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif" font-weight="900" font-size="58" text-anchor="middle">W</text>
                             </svg>',
        };
    }
}
