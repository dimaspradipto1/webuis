<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InformasiPmbHumas extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'informasi_pmb_humas';

    protected $fillable = [
        'judul',
        'subjudul',
        'badge_text',
        'deskripsi_singkat',
        'file_pdf',
        'file_pdf_nama',
        'gambar_brosur',
        'gambar_brosur_2',
        'link_pendaftaran',
        'no_wa_pmb',
        'gelombang_info',
        'persyaratan_info',
        'beasiswa_info',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getPdfUrlAttribute(): ?string
    {
        if (! $this->file_pdf) {
            return null;
        }

        if (str_starts_with($this->file_pdf, 'http://') || str_starts_with($this->file_pdf, 'https://')) {
            return $this->file_pdf;
        }

        return asset('storage/' . $this->file_pdf);
    }

    public function getGambarBrosurUrlAttribute(): ?string
    {
        if (! $this->gambar_brosur) {
            return null;
        }

        if (str_starts_with($this->gambar_brosur, 'http://') || str_starts_with($this->gambar_brosur, 'https://')) {
            return $this->gambar_brosur;
        }

        return asset('storage/' . $this->gambar_brosur);
    }

    public function getGambarBrosur2UrlAttribute(): ?string
    {
        if (! $this->gambar_brosur_2) {
            return null;
        }

        if (str_starts_with($this->gambar_brosur_2, 'http://') || str_starts_with($this->gambar_brosur_2, 'https://')) {
            return $this->gambar_brosur_2;
        }

        return asset('storage/' . $this->gambar_brosur_2);
    }

    public function getPdfSizeAttribute(): ?string
    {
        if (! $this->file_pdf || ! Storage::disk('public')->exists($this->file_pdf)) {
            return null;
        }

        $bytes = Storage::disk('public')->size($this->file_pdf);
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }

        return number_format($bytes / 1024, 0) . ' KB';
    }

    public function getCleanWaAttribute(): string
    {
        $raw = preg_replace('/[^0-9]/', '', (string) ($this->no_wa_pmb ?? '082283958644'));
        if (str_starts_with($raw, '0')) {
            return '62' . substr($raw, 1);
        }
        if (str_starts_with($raw, '8')) {
            return '62' . $raw;
        }

        return $raw ?: '6282283958644';
    }
}
