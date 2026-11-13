<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Pengaturan tampilan frontend (warna header, footer & tata letak beranda).
 * Disimpan sebagai berkas JSON di storage publik agar tidak mengubah struktur database.
 */
class TampilanConfig
{
    private const FILE_PATH = 'settings/tampilan.json';

    private static ?array $cache = null;

    /**
     * Daftar section beranda sesuai id elemen <section> di homepage.blade.php.
     */
    public static function sectionCatalog(): array
    {
        return [
            'hero-banner' => ['label' => 'Banner Hero (Slider)', 'icon' => 'bi-images'],
            'keunggulan-beranda' => ['label' => 'Kartu Keunggulan Beranda', 'icon' => 'bi-layers'],
            'profil-singkat' => ['label' => 'Profil Universitas & Video', 'icon' => 'bi-building'],
            'statistik-fakultas' => ['label' => 'Statistik Universitas', 'icon' => 'bi-bar-chart-line'],
            'keunggulan' => ['label' => 'Keunggulan Universitas', 'icon' => 'bi-patch-check'],
            'pmb' => ['label' => 'Banner PMB & Pendaftaran', 'icon' => 'bi-pencil-square'],
            'fasilitas' => ['label' => 'Sarana & Fasilitas Kampus', 'icon' => 'bi-cpu'],
            'prestasi' => ['label' => 'Prestasi Mahasiswa', 'icon' => 'bi-trophy'],
            'organisasi-mahasiswa' => ['label' => 'Organisasi Mahasiswa', 'icon' => 'bi-people'],
            'galeri' => ['label' => 'Galeri Kegiatan', 'icon' => 'bi-camera'],
            'media-sosial' => ['label' => 'Media Sosial', 'icon' => 'bi-instagram'],
            'berita' => ['label' => 'Berita Terkini', 'icon' => 'bi-newspaper'],
            'alumni' => ['label' => 'Alumni & Testimoni', 'icon' => 'bi-mortarboard'],
            'layanan-terkait' => ['label' => 'Layanan Terkait', 'icon' => 'bi-grid'],
            'mitra' => ['label' => 'Mitra Kerjasama', 'icon' => 'bi-diagram-3'],
            'faq' => ['label' => 'Tanya Jawab (FAQ)', 'icon' => 'bi-question-circle'],
        ];
    }

    public static function presets(): array
    {
        return [
            'hijau-uis' => [
                'label' => 'Hijau Khas UIS (Default)',
                'header' => ['nav_bg' => '#046b26', 'nav_text' => '#ffffff', 'nav_accent' => '#fed802', 'pmb_bg' => '#ffffff', 'pmb_text' => '#046b26'],
                'footer' => ['footer_bg' => '#023814', 'footer_text' => '#e2efe6', 'footer_heading' => '#ffffff', 'footer_accent' => '#fed802'],
            ],
            'kuning-uis' => [
                'label' => 'Kuning Khas UIS',
                'header' => ['nav_bg' => '#fed802', 'nav_text' => '#111111', 'nav_accent' => '#046b26', 'pmb_bg' => '#046b26', 'pmb_text' => '#ffffff'],
                'footer' => ['footer_bg' => '#111111', 'footer_text' => '#d4d4d4', 'footer_heading' => '#ffffff', 'footer_accent' => '#fed802'],
            ],
            'hitam-elegan' => [
                'label' => 'Hitam Elegan (Dark Modern)',
                'header' => ['nav_bg' => '#0f172a', 'nav_text' => '#ffffff', 'nav_accent' => '#fbbf24', 'pmb_bg' => '#fbbf24', 'pmb_text' => '#0f172a'],
                'footer' => ['footer_bg' => '#020617', 'footer_text' => '#cbd5e1', 'footer_heading' => '#ffffff', 'footer_accent' => '#fbbf24'],
            ],
            'putih-bersih' => [
                'label' => 'Putih Bersih (Clean Light)',
                'header' => ['nav_bg' => '#ffffff', 'nav_text' => '#0f172a', 'nav_accent' => '#046b26', 'pmb_bg' => '#046b26', 'pmb_text' => '#ffffff'],
                'footer' => ['footer_bg' => '#f8fafc', 'footer_text' => '#475569', 'footer_heading' => '#0f172a', 'footer_accent' => '#046b26'],
            ],
            'biru-teknologi' => [
                'label' => 'Biru Teknologi (Tech Slate)',
                'header' => ['nav_bg' => '#1e3a8a', 'nav_text' => '#ffffff', 'nav_accent' => '#facc15', 'pmb_bg' => '#ffffff', 'pmb_text' => '#1e3a8a'],
                'footer' => ['footer_bg' => '#172554', 'footer_text' => '#cbd5e1', 'footer_heading' => '#ffffff', 'footer_accent' => '#facc15'],
            ],
            'hijau-zamrud' => [
                'label' => 'Hijau Zamrud (Emerald)',
                'header' => ['nav_bg' => '#065f46', 'nav_text' => '#ffffff', 'nav_accent' => '#6ee7b7', 'pmb_bg' => '#ffffff', 'pmb_text' => '#065f46'],
                'footer' => ['footer_bg' => '#022c22', 'footer_text' => '#d1fae5', 'footer_heading' => '#ffffff', 'footer_accent' => '#6ee7b7'],
            ],
        ];
    }

    public static function defaults(): array
    {
        $preset = self::presets()['hijau-uis'];
        $sections = [];
        $i = 1;
        foreach (array_keys(self::sectionCatalog()) as $key) {
            $sections[$key] = ['order' => $i++, 'visible' => true];
        }

        return [
            'header' => array_merge([
                'logo' => null,
                'judul' => 'UNIVERSITAS IBNU SINA',
                'subjudul' => '',
            ], $preset['header']),
            'footer' => array_merge([
                'deskripsi' => 'Universitas Ibnu Sina (UIS) Batam — Kampusnya Profesional Muda. Berkomitmen menyelenggarakan pendidikan tinggi unggul, bermartabat, bereputasi nasional dan internasional serta berjiwa entrepreneur berbasis Imtaq.',
                'copyright' => 'Universitas Ibnu Sina (UIS). All rights reserved.',
                'jam_operasional' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
            ], $preset['footer']),
            'layout' => $sections,
        ];
    }

    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $data = self::defaults();
        try {
            if (Storage::disk('public')->exists(self::FILE_PATH)) {
                $saved = json_decode((string) Storage::disk('public')->get(self::FILE_PATH), true);
                if (is_array($saved)) {
                    $data['header'] = array_merge($data['header'], (array) ($saved['header'] ?? []));
                    $data['footer'] = array_merge($data['footer'], (array) ($saved['footer'] ?? []));
                    foreach ((array) ($saved['layout'] ?? []) as $key => $row) {
                        if (isset($data['layout'][$key])) {
                            $data['layout'][$key] = [
                                'order' => (int) ($row['order'] ?? $data['layout'][$key]['order']),
                                'visible' => (bool) ($row['visible'] ?? true),
                            ];
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Gunakan nilai default bila berkas tidak terbaca
        }

        uasort($data['layout'], fn ($a, $b) => $a['order'] <=> $b['order']);

        return self::$cache = $data;
    }

    public static function get(): object
    {
        $data = self::all();
        $header = $data['header'];

        return (object) [
            'header' => (object) array_merge($header, [
                'logo_url' => ! empty($header['logo']) && Storage::disk('public')->exists($header['logo'])
                    ? asset('storage/'.$header['logo'])
                    : asset('assets/img/logouis.png'),
            ]),
            'footer' => (object) $data['footer'],
            'layout' => $data['layout'],
        ];
    }

    public static function save(string $group, array $values): void
    {
        $data = self::all();
        if ($group === 'layout') {
            $data['layout'] = $values;
        } else {
            $data[$group] = array_merge($data[$group], $values);
        }
        $data['updated_at'] = now()->toIso8601String();

        Storage::disk('public')->put(self::FILE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        self::$cache = null;
    }

    public static function reset(string $group): void
    {
        $data = self::all();
        $defaults = self::defaults();
        if ($group === 'header') {
            // Pertahankan logo yang sudah diunggah, kembalikan warna & teks
            $defaults['header']['logo'] = $data['header']['logo'] ?? null;
        }
        $data[$group] = $defaults[$group];
        Storage::disk('public')->put(self::FILE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        self::$cache = null;
    }

    public static function lastModified(): ?int
    {
        $path = storage_path('app/public/'.self::FILE_PATH);

        return file_exists($path) ? filemtime($path) : null;
    }

    /**
     * True bila warna terang (dipakai untuk menentukan ikon toggler mobile).
     */
    public static function isLight(string $hex): bool
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        if (strlen($hex) !== 6) {
            return false;
        }
        [$r, $g, $b] = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];

        return (0.299 * $r + 0.587 * $g + 0.114 * $b) > 160;
    }
}

