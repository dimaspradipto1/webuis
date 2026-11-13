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
            'keunggulan-beranda' => ['label' => 'Keunggulan Beranda', 'icon' => 'bi-layers'],
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
                'header' => ['nav_bg' => '#046b26', 'nav_text' => '#ffffff', 'nav_accent' => '#fed802', 'pmb_bg' => '#ffffff', 'pmb_text' => '#046b26', 'lang_visible' => true, 'lang_bg' => '#2e743b', 'lang_text' => '#ffffff', 'lang_border' => '#d6bd36'],
                'footer' => ['footer_bg' => '#023814', 'footer_text' => '#e2efe6', 'footer_heading' => '#ffffff', 'footer_accent' => '#fed802'],
            ],
            'kuning-uis' => [
                'label' => 'Kuning UIS Elegan',
                'header' => ['nav_bg' => '#f6df68', 'nav_text' => '#174b2b', 'nav_accent' => '#14532d', 'pmb_bg' => '#14532d', 'pmb_text' => '#ffffff', 'lang_visible' => true, 'lang_bg' => '#fff3b0', 'lang_text' => '#174b2b', 'lang_border' => '#14532d'],
                'footer' => ['footer_bg' => '#174b2b', 'footer_text' => '#e5eee7', 'footer_heading' => '#ffffff', 'footer_accent' => '#f6df68'],
            ],
            'hitam-elegan' => [
                'label' => 'Hijau Premium & Emas',
                'header' => ['nav_bg' => '#174b2b', 'nav_text' => '#ffffff', 'nav_accent' => '#e7c65a', 'pmb_bg' => '#e7c65a', 'pmb_text' => '#174b2b', 'lang_visible' => true, 'lang_bg' => '#245b36', 'lang_text' => '#ffffff', 'lang_border' => '#e7c65a'],
                'footer' => ['footer_bg' => '#103922', 'footer_text' => '#e2ece4', 'footer_heading' => '#ffffff', 'footer_accent' => '#e7c65a'],
            ],
            'putih-bersih' => [
                'label' => 'Putih Bersih UIS',
                'header' => ['nav_bg' => '#f7faf7', 'nav_text' => '#174b2b', 'nav_accent' => '#c7a928', 'pmb_bg' => '#174b2b', 'pmb_text' => '#ffffff', 'lang_visible' => true, 'lang_bg' => '#edf4ee', 'lang_text' => '#174b2b', 'lang_border' => '#c7a928'],
                'footer' => ['footer_bg' => '#edf4ee', 'footer_text' => '#365342', 'footer_heading' => '#174b2b', 'footer_accent' => '#b89b22'],
            ],
            'biru-teknologi' => [
                'label' => 'Hijau Tua & Kuning Lembut',
                'header' => ['nav_bg' => '#123f31', 'nav_text' => '#ffffff', 'nav_accent' => '#e8d36b', 'pmb_bg' => '#ffffff', 'pmb_text' => '#123f31', 'lang_visible' => true, 'lang_bg' => '#205443', 'lang_text' => '#ffffff', 'lang_border' => '#e8d36b'],
                'footer' => ['footer_bg' => '#0d3025', 'footer_text' => '#dce9e2', 'footer_heading' => '#ffffff', 'footer_accent' => '#e8d36b'],
            ],
            'hijau-zamrud' => [
                'label' => 'Zamrud & Kuning UIS',
                'header' => ['nav_bg' => '#08634d', 'nav_text' => '#ffffff', 'nav_accent' => '#f2d45c', 'pmb_bg' => '#ffffff', 'pmb_text' => '#08634d', 'lang_visible' => true, 'lang_bg' => '#18745d', 'lang_text' => '#ffffff', 'lang_border' => '#f2d45c'],
                'footer' => ['footer_bg' => '#064536', 'footer_text' => '#e0eee8', 'footer_heading' => '#ffffff', 'footer_accent' => '#f2d45c'],
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
                'lang_visible' => true,
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
