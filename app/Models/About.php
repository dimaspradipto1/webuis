<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';

    protected $fillable = [
        'judul_profil',
        'deskripsi_profil_1',
        'deskripsi_profil_2',
        'video_url',
        'video_file',
        'visi',
        'visi_judul',
        'visi_icon',
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
}
