<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahasaSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'bahasa_settings';

    protected $fillable = [
        'kode',
        'nama',
        'bendera',
        'kode_negara',
        'urutan',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Scope for active languages ordered by display sequence.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan')->orderBy('id');
    }

    /**
     * Get flag image URL with flexible priority:
     * 1. Uploaded flag image in 'bendera' (file path / URL)
     * 2. Country code in 'kode_negara' (local asset / flagcdn)
     * 3. Fallback based on language code 'kode'
     * 4. Default fallback flag
     */
    public function getFlagUrlAttribute(): string
    {
        // 1. Cek jika 'bendera' berisi path file upload atau URL
        if (! empty($this->bendera)) {
            $benderaVal = trim($this->bendera);
            if (str_contains($benderaVal, '/') || str_contains($benderaVal, '.')) {
                if (file_exists(public_path($benderaVal))) {
                    return asset($benderaVal);
                }
                if (str_starts_with($benderaVal, 'http://') || str_starts_with($benderaVal, 'https://')) {
                    return $benderaVal;
                }
            }
        }

        // 2. Cek kode negara (misal: 'id', 'ps', 'gb', 'sa', 'tr', 'ple', 'ina', 'idn', 'gbr')
        $rawCode = ! empty($this->kode_negara) ? $this->kode_negara : $this->kode;
        $code = strtolower(trim($rawCode ?? ''));

        // Normalisasi alias dari kode IOC, FIFA, ISO 3166-1 alpha-3 ke ISO 3166-1 alpha-2
        $map = [
            // Palestina (IOC: PLE, ISO-3: PSE) -> ps
            'ple' => 'ps', 'pse' => 'ps', 'palestina' => 'ps', 'palestine' => 'ps',
            // Indonesia (IOC: INA, FIFA/ISO-3: IDN) -> id
            'ina' => 'id', 'idn' => 'id', 'indonesia' => 'id',
            // Inggris / UK (IOC/ISO-3: GBR, FIFA: ENG) -> gb
            'gbr' => 'gb', 'eng' => 'gb', 'uk' => 'gb', 'en' => 'gb',
            // Arab Saudi (IOC/FIFA: KSA, ISO-3: SAU) -> sa
            'ksa' => 'sa', 'sau' => 'sa', 'ar' => 'sa',
            // Amerika Serikat (IOC/FIFA/ISO-3: USA) -> us
            'usa' => 'us',
            // Turki (IOC/FIFA/ISO-3: TUR) -> tr
            'tur' => 'tr',
            // Spanyol (IOC/FIFA/ISO-3: ESP) -> es
            'esp' => 'es', 'spa' => 'es',
            // Jerman (IOC: GER, FIFA/ISO-3: DEU) -> de
            'ger' => 'de', 'deu' => 'de',
            // Prancis (IOC/FIFA/ISO-3: FRA) -> fr
            'fra' => 'fr',
            // Belanda (IOC/FIFA: NED, ISO-3: NLD) -> nl
            'ned' => 'nl', 'nld' => 'nl',
            // Filipina (IOC: PHI, FIFA/ISO-3: PHL) -> ph
            'phi' => 'ph', 'phl' => 'ph', 'fil' => 'ph', 'tl' => 'ph',
            // India (IOC/FIFA/ISO-3: IND) -> in
            'ind' => 'in', 'hi' => 'in',
            // Italia (IOC/FIFA/ISO-3: ITA) -> it
            'ita' => 'it',
            // Jepang (IOC/FIFA/ISO-3: JPN) -> jp
            'jpn' => 'jp', 'ja' => 'jp',
            // Korea Selatan (IOC/FIFA/ISO-3: KOR) -> kr
            'kor' => 'kr', 'ko' => 'kr',
            // China (IOC/FIFA/ISO-3: CHN) -> cn
            'chn' => 'cn', 'zh' => 'cn', 'zh-cn' => 'cn',
            // Malaysia (IOC: MAS, FIFA/ISO-3: MYS) -> my
            'mas' => 'my', 'mys' => 'my',
            // Singapura (IOC/FIFA: SIN, ISO-3: SGP) -> sg
            'sin' => 'sg', 'sgp' => 'sg',
            // Mesir (IOC/FIFA/ISO-3: EGY) -> eg
            'egy' => 'eg',
        ];

        if (isset($map[$code])) {
            $code = $map[$code];
        }

        // Cek file lokal
        if (! empty($code) && file_exists(public_path("assets/img/flags/{$code}.png"))) {
            return asset("assets/img/flags/{$code}.png");
        }

        // Cek FlagCDN jika 2 huruf ISO
        if (strlen($code) === 2) {
            return "https://flagcdn.com/w40/{$code}.png";
        }

        return asset('assets/img/flags/id.png');
    }

    /**
     * Cek apakah menggunakan custom upload atau kode negara.
     */
    public function getTipeBenderaAttribute(): string
    {
        if (! empty($this->bendera) && (str_contains($this->bendera, '/') || str_contains($this->bendera, '.'))) {
            return 'upload';
        }
        if (! empty($this->kode_negara)) {
            return 'kode';
        }

        return 'otomatis';
    }
}
