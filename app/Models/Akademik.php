<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akademik extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'akademiks';

    protected $fillable = [
        'tipe',
        'judul',
        'subjudul',
        'deskripsi',
        'agenda_items',
        'file_dokumen',
        'file_nama',
        'link_url',
        'gambar',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'agenda_items' => 'array',
    ];

    public function getFileDokumenUrlAttribute(): ?string
    {
        if (empty($this->file_dokumen)) {
            return null;
        }

        if (str_starts_with($this->file_dokumen, 'http://') || str_starts_with($this->file_dokumen, 'https://')) {
            return $this->file_dokumen;
        }

        $publicAsset = 'assets/dokumen/akademik/' . basename($this->file_dokumen);
        if (file_exists(public_path($publicAsset))) {
            return asset($publicAsset);
        }

        return asset('storage/' . ltrim($this->file_dokumen, '/'));
    }

    public function getGambarUrlAttribute(): ?string
    {
        if (empty($this->gambar)) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        $publicAsset = 'assets/img/akademik/' . basename($this->gambar);
        if (file_exists(public_path($publicAsset))) {
            return asset($publicAsset);
        }

        return asset('storage/' . ltrim($this->gambar, '/'));
    }
}
