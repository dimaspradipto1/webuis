<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unduhan extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'unduhans';

    protected $fillable = [
        'judul',
        'kategori',
        'file_path',
        'file_url',
        'file_size',
        'deskripsi',
        'urutan',
        'is_active',
        'download_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Dapatkan URL Download (File lokal storage atau URL eksternal)
     */
    public function getDownloadUrlAttribute(): string
    {
        if ($this->file_path) {
            return asset('storage/'.$this->file_path);
        }

        return $this->file_url ?? '#';
    }

    /**
     * Dapatkan Icon Kategori
     */
    public function getCategoryIconAttribute(): string
    {
        return match ($this->kategori) {
            'image' => 'bi-image',
            'video' => 'bi-camera-video',
            'audio' => 'bi-music-note-beamed',
            'template' => 'bi-brush',
            default => 'bi-file-earmark-arrow-down',
        };
    }
}
