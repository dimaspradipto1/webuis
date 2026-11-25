<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'abouts';

    protected $fillable = [
        'judul_profil',
        'deskripsi_profil_1',
        'deskripsi_profil_2',
        'video_url',
        'video_file',
        'dokumen_file',
        'dokumen_nama',
        'dokumen_link',
        'visi',
        'visi_judul',
        'visi_icon',
        'visimisi_label',
        'visimisi_judul',
        'visimisi_deskripsi',
        'visimisi_background',
        'visimisi_padding_top',
        'visimisi_padding_bottom',
        'visimisi_tagline_visi',
        'visimisi_misi_items',
        'visimisi_tatanilai_judul',
        'visimisi_tatanilai_items',
        'visimisi_badge_humas',
        'visimisi_footer_fb',
        'visimisi_footer_ig',
        'visimisi_footer_url',
        'misi',
        'misi_judul',
        'misi_icon',
        'judul_nilai',
        'deskripsi_nilai',
        'nilai_1_judul',
        'nilai_1_deskripsi',
        'nilai_1_icon',
        'nilai_2_judul',
        'nilai_2_deskripsi',
        'nilai_2_icon',
        'nilai_3_judul',
        'nilai_3_deskripsi',
        'nilai_3_icon',
        'nilai_4_judul',
        'nilai_4_deskripsi',
        'nilai_4_icon',
        'sejarah_label',
        'sejarah_judul',
        'sejarah_judul_highlight',
        'sejarah_deskripsi_1',
        'sejarah_deskripsi_2',
        'sejarah_card_judul',
        'sejarah_card_subjudul',
        'sejarah_card_narasi',
        'sejarah_pilar_1',
        'sejarah_pilar_2',
        'sejarah_pilar_3',
    ];

    /**
     * Cek apakah terdapat video (baik URL maupun file upload).
     */
    public function hasVideo(): bool
    {
        return ! empty($this->video_url) || ! empty($this->video_file);
    }

    /**
     * Cek apakah terdapat dokumen profil (upload berkas atau link gdrive/cloud).
     */
    public function hasDokumen(): bool
    {
        return ! empty($this->dokumen_file) || ! empty($this->dokumen_link);
    }

    /**
     * Dapatkan URL dokumen profil baik dari storage lokal maupun link eksternal.
     */
    public function getDokumenUrlAttribute(): ?string
    {
        if (! empty($this->dokumen_file)) {
            return asset('storage/' . $this->dokumen_file);
        }

        if (! empty($this->dokumen_link)) {
            return $this->dokumen_link;
        }

        return null;
    }

    /**
     * Ekstrak 11 digit video ID YouTube dari segala jenis format link atau kode iframe.
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        $input = trim($this->video_url);

        // Jika user mem-paste seluruh kode <iframe>
        if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $input, $frameMatch)) {
            $input = $frameMatch[1];
        }

        // Jika user langsung memasukkan 11 karakter video ID
        if (preg_match('/^[a-zA-Z0-9_\-]{11}$/', $input)) {
            return $input;
        }

        // Regex universal untuk segala macam variasi format URL YouTube
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|live|shorts)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/i', $input, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Konversi URL video YouTube / external ke format embed iframe resmi.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $id = $this->youtube_video_id;
        if ($id) {
            return 'https://www.youtube.com/embed/'.$id;
        }

        if (! empty($this->video_url)) {
            $url = trim($this->video_url);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $url, $frameMatch)) {
                return $frameMatch[1];
            }

            return $url;
        }

        return null;
    }

    /**
     * URL tautan langsung ke halaman tonton YouTube.
     */
    public function getYoutubeWatchUrlAttribute(): ?string
    {
        $id = $this->youtube_video_id;
        if ($id) {
            return 'https://www.youtube.com/watch?v='.$id;
        }

        return ! empty($this->video_url) ? trim($this->video_url) : null;
    }

    /**
     * URL background gambar utama visi misi.
     */
    public function getVisimisiBackgroundUrlAttribute(): ?string
    {
        if (!empty($this->visimisi_background)) {
            $raw = trim($this->visimisi_background);

            if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
                return $raw;
            }

            $cleanPath = ltrim(preg_replace('#^(public/|storage/)#', '', $raw), '/');
            $baseName = basename($cleanPath);
            $subPath = str_contains($cleanPath, '/') ? $cleanPath : ('visi-misi/' . $cleanPath);

            // 1. Cek di public/assets/img/ (jika tersalin langsung ke folder assets)
            if (file_exists(public_path('assets/img/' . $baseName))) {
                $ver = filemtime(public_path('assets/img/' . $baseName));
                return asset('assets/img/' . $baseName) . '?v=' . $ver;
            }

            // 2. Cek di public/storage/ (jika symlink aktif)
            if (file_exists(public_path('storage/' . $subPath))) {
                $ver = filemtime(public_path('storage/' . $subPath));
                return asset('storage/' . $subPath) . '?v=' . $ver;
            }
            if (file_exists(public_path('storage/' . $cleanPath))) {
                $ver = filemtime(public_path('storage/' . $cleanPath));
                return asset('storage/' . $cleanPath) . '?v=' . $ver;
            }

            // 3. Cek di Storage disk public (melalui storage fallback route di web.php)
            try {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($subPath)) {
                    return asset('storage/' . $subPath) . '?v=' . time();
                }
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                    return asset('storage/' . $cleanPath) . '?v=' . time();
                }
            } catch (\Throwable $e) {}

            // 4. Cek di public root
            if (file_exists(public_path($cleanPath))) {
                $ver = filemtime(public_path($cleanPath));
                return asset($cleanPath) . '?v=' . $ver;
            }
        }

        // Default background gambar Visi Misi resmi UIS (bersih tanpa teks)
        if (file_exists(public_path('assets/img/visimisi-campus-clean-bg.jpg'))) {
            $ver = filemtime(public_path('assets/img/visimisi-campus-clean-bg.jpg'));
            return asset('assets/img/visimisi-campus-clean-bg.jpg') . '?v=' . $ver;
        }
        if (file_exists(public_path('assets/img/visimisi-default-bg.jpg'))) {
            $ver = filemtime(public_path('assets/img/visimisi-default-bg.jpg'));
            return asset('assets/img/visimisi-default-bg.jpg') . '?v=' . $ver;
        }

        return asset('assets/img/visimisi-campus-clean-bg.jpg');
    }

    /**
     * Daftar butir-butir Misi dalam bentuk array.
     */
    public function getMisiListAttribute(): array
    {
        if (empty($this->visimisi_misi_items)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', trim($this->visimisi_misi_items));
        return array_values(array_filter(array_map('trim', $lines)));
    }

    /**
     * Daftar butir-butir Tata Nilai UIS CIP dalam bentuk array.
     */
    public function getTataNilaiListAttribute(): array
    {
        if (empty($this->visimisi_tatanilai_items)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', trim($this->visimisi_tatanilai_items));
        return array_values(array_filter(array_map('trim', $lines)));
    }
}
