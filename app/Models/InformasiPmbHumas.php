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

    /**
     * Parse daftar gelombang dari teks admin gelombang_info menjadi array card dinamis.
     */
    public function getParsedGelombangAttribute(): array
    {
        $defaultWaves = [
            [
                'wave' => 'Gelombang I',
                'title' => 'Gelombang Dini & Prestasi',
                'date' => 'Januari – Maret 2026',
                'badge' => 'Sedang Dibuka',
                'badge_class' => 'bg-success text-white',
                'active' => true,
                'btn_text' => 'Daftar Gelombang I',
                'btn_class' => 'btn-success',
                'btn_style' => 'background-color: #046B26;',
                'perks' => [
                    'Potongan Biaya Pendaftaran Awal',
                    'Prioritas Seleksi Jalur Beasiswa Kuliah',
                    'Kepastian Kuota Program Studi Pilihan',
                ],
            ],
            [
                'wave' => 'Gelombang II',
                'title' => 'Gelombang Reguler Utama',
                'date' => 'April – Juni 2026',
                'badge' => 'Mendatang',
                'badge_class' => 'bg-primary-subtle text-primary border border-primary-subtle',
                'active' => false,
                'btn_text' => 'Daftar Gelombang II',
                'btn_class' => 'btn-outline-success',
                'btn_style' => '',
                'perks' => [
                    'Jalur Reguler Sarjana (S1) & Magister (S2)',
                    'Seleksi Administrasi & CBT Online',
                    'Program Beasiswa Kemitraan & Yayasan',
                ],
            ],
            [
                'wave' => 'Gelombang III',
                'title' => 'Gelombang Penutup',
                'date' => 'Juli – September 2026',
                'badge' => 'Kuota Terakhir',
                'badge_class' => 'bg-warning-subtle text-dark border border-warning-subtle',
                'active' => false,
                'btn_text' => 'Informasi Gelombang III',
                'btn_class' => 'btn-outline-secondary',
                'btn_style' => '',
                'perks' => [
                    'Pengisian Kuota Terakhir Program Studi',
                    'Tes Masuk & Wawancara Khusus',
                    'Pembekalan PKKMB Mahasiswa Baru',
                ],
            ],
        ];

        $raw = trim((string) ($this->gelombang_info ?? ''));
        if (empty($raw)) {
            return $defaultWaves;
        }

        $lines = array_values(array_filter(array_map('trim', explode("\n", $raw))));
        if (empty($lines)) {
            return $defaultWaves;
        }

        $result = [];
        foreach ($lines as $index => $line) {
            $cleanLine = ltrim($line, "•*- 0..9.)");
            $wave = 'Gelombang ' . ($index + 1);
            $date = $cleanLine;
            $title = $defaultWaves[$index]['title'] ?? ('Penerimaan Gelombang ' . ($index + 1));

            if (str_contains($cleanLine, ':')) {
                $parts = explode(':', $cleanLine, 2);
                $wave = trim($parts[0]);
                $date = trim($parts[1]);
            }

            if (preg_match('/^(.*?)\s*\((.*?)\)$/', $date, $matches)) {
                $date = trim($matches[1]);
                $title = trim($matches[2]);
            }

            $badge = $defaultWaves[$index]['badge'] ?? ($index === 0 ? 'Sedang Dibuka' : 'Informasi Gelombang');
            $badgeClass = $defaultWaves[$index]['badge_class'] ?? ($index === 0 ? 'bg-success text-white' : 'bg-primary-subtle text-primary border border-primary-subtle');
            $btnText = $defaultWaves[$index]['btn_text'] ?? ('Daftar ' . $wave);
            $btnClass = $defaultWaves[$index]['btn_class'] ?? ($index === 0 ? 'btn-success' : 'btn-outline-success');
            $btnStyle = $defaultWaves[$index]['btn_style'] ?? ($index === 0 ? 'background-color: #046B26;' : '');
            $active = ($index === 0);
            $perks = $defaultWaves[$index]['perks'] ?? [
                'Pendaftaran Online Portal PMB',
                'Seleksi Administrasi & Verifikasi Berkas',
                'Pilihan Program Studi Terakreditasi',
            ];

            $result[] = [
                'wave' => $wave,
                'title' => $title,
                'date' => $date,
                'badge' => $badge,
                'badge_class' => $badgeClass,
                'active' => $active,
                'btn_text' => $btnText,
                'btn_class' => $btnClass,
                'btn_style' => $btnStyle,
                'perks' => $perks,
            ];
        }

        return !empty($result) ? $result : $defaultWaves;
    }
}
