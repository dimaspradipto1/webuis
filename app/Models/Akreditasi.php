<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Akreditasi extends Model
{
    use HasFactory;

    protected $table = 'akreditasis';

    protected $fillable = [
        'tingkat',
        'kategori_label',
        'nama',
        'jenjang',
        'lembaga',
        'peringkat',
        'nomor_sk',
        'tahun_sk',
        'masa_berlaku',
        'file_sertifikat',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUniversitas($query)
    {
        return $query->where('tingkat', 'universitas');
    }

    public function scopeFakultas($query)
    {
        return $query->where('tingkat', 'fakultas');
    }

    public function scopeProdi($query)
    {
        return $query->where('tingkat', 'prodi');
    }

    public function getFileUrlAttribute(): ?string
    {
        if (empty($this->file_sertifikat)) {
            return null;
        }

        if (str_starts_with($this->file_sertifikat, 'http://') || str_starts_with($this->file_sertifikat, 'https://')) {
            return $this->file_sertifikat;
        }

        $cleanPath = ltrim($this->file_sertifikat, '/');

        // Check if file physically exists in public
        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        // Check if file exists in public/storage
        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        return asset('storage/' . $cleanPath);
    }

    public function getBadgeClassAttribute(): string
    {
        $p = strtolower(trim($this->peringkat));
        return match (true) {
            str_contains($p, 'unggul') => 'bg-warning text-dark',
            str_contains($p, 'baik sekali') => 'bg-success text-white',
            str_contains($p, 'baik') => 'bg-primary text-white',
            str_contains($p, 'a') => 'bg-warning text-dark',
            str_contains($p, 'b') => 'bg-info text-dark',
            default => 'bg-secondary text-white',
        };
    }
}
