<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'features';

    protected $fillable = [
        'icon',
        'judul',
        'deskripsi',
        'urutan',
    ];

    protected $appends = [
        'badge',
    ];

    public function getIconAttribute($value): string
    {
        $raw = (string) ($value ?? '');
        if (str_contains($raw, '|')) {
            return trim(explode('|', $raw, 2)[0]) ?: 'bi-layers';
        }

        return trim($raw) ?: 'bi-layers';
    }

    public function getBadgeAttribute(): string
    {
        $raw = (string) ($this->attributes['icon'] ?? '');
        if (str_contains($raw, '|')) {
            $badge = trim(explode('|', $raw, 2)[1] ?? '');
            if ($badge !== '') {
                return $badge;
            }
        }

        return match ((int) ($this->attributes['urutan'] ?? 0)) {
            1 => 'TERAKREDITASI',
            2 => 'AKTIF 2024',
            3 => 'MOU AKTIF',
            4 => 'BUKA 2025',
            default => 'AKTIF',
        };
    }

    public function setDeskripsiAttribute($value): void
    {
        $this->attributes['deskripsi'] = is_string($value)
            ? trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            : $value;
    }

    public static function packIconAndBadge(string $icon, ?string $badge): string
    {
        $cleanIcon = trim(explode('|', $icon, 2)[0]) ?: 'bi-layers';
        $cleanBadge = trim((string) $badge);

        return $cleanBadge !== '' ? "{$cleanIcon}|{$cleanBadge}" : $cleanIcon;
    }
}
