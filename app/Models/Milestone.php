<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'milestones';

    protected $fillable = [
        'tahun',
        'judul',
        'deskripsi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($milestone) {
            if (! empty($milestone->deskripsi)) {
                $milestone->deskripsi = self::cleanTextWithLineBreaks($milestone->deskripsi);
            }
        });
    }

    /**
     * Bersihkan tag HTML (seperti <p> atau &lt;p&gt;) menjadi baris baru (Enter) murni.
     */
    public function getCleanDeskripsiAttribute(): string
    {
        return self::cleanTextWithLineBreaks($this->deskripsi ?? '');
    }

    public static function cleanTextWithLineBreaks(?string $raw): string
    {
        if (empty($raw)) {
            return '';
        }

        // Decode entitas HTML (termasuk jika ter-encode 2x seperti &amp;lt;p&amp;gt;)
        $text = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Ubah tag penutup paragraf & br menjadi baris baru (Enter) sebelum strip_tags
        $text = preg_replace('/<\/p>\s*<p[^>]*>/i', "\n\n", $text);
        $text = preg_replace('/<\/(p|div|li|h[1-6])>/i', "\n\n", $text);
        $text = preg_replace('/<br\s*\/?>/i', "\n", $text);

        // Hapus seluruh sisa tag HTML
        $text = strip_tags($text);

        // Decode ulang jika masih ada entitas seperti &nbsp;
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xc2\xa0", ' ', $text);

        // Rapikan baris kosong berlebih (maksimal 2 newline berturut-turut)
        $text = preg_replace("/\r\n|\r/", "\n", $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }
}
