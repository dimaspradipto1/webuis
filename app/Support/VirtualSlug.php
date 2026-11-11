<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VirtualSlug
{
    /**
     * In-memory cache of resolved slugs by [ModelClass:id].
     *
     * @var array<string, string>
     */
    protected static array $cache = [];

    /**
     * Title attributes checked in priority order when building a readable slug prefix.
     *
     * @var array<int, string>
     */
    protected static array $titleAttributes = [
        'title',
        'judul',
        'judul_prestasi',
        'nama',
        'nama_organisasi',
        'nama_dosen',
        'nama_mitra',
        'pertanyaan',
        'platform',
        'name',
        'label',
        'jabatan',
        'kategori',
        'tipe',
        'email',
    ];

    /**
     * Encode a numeric ID and optional human-readable title into a non-DB signed virtual slug.
     */
    public static function encode(int|string $id, ?string $title = null, string $fallbackPrefix = 'item'): string
    {
        $numericId = (int) $id;
        $key = (string) config('app.key', 'webuis-virtual-slug-secret');

        $sig = substr(hash_hmac('sha256', 'vslug:' . $numericId, $key), 0, 6);
        $mask = hexdec(substr(hash_hmac('sha256', 'mask:' . $sig, $key), 0, 5));
        $obfuscated = $numericId ^ $mask;
        $token = $sig . base_convert((string) $obfuscated, 10, 36);

        $cleanTitle = '';
        if (! empty($title)) {
            $cleanTitle = trim(html_entity_decode(strip_tags($title), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }

        $prefix = Str::limit(Str::slug($cleanTitle), 50, '');
        $prefix = rtrim($prefix, '-');

        if ($prefix === '') {
            $prefix = Str::slug($fallbackPrefix) ?: 'item';
        }

        return $prefix . '-' . $token;
    }

    /**
     * Decode a virtual slug (or numeric string) back into its integer ID.
     * Returns null if the string is not a valid virtual slug or numeric ID.
     */
    public static function decode(mixed $slugOrId): ?int
    {
        if ($slugOrId === null || $slugOrId === '') {
            return null;
        }

        $str = (string) $slugOrId;
        if (ctype_digit($str)) {
            return (int) $str;
        }

        $lastDash = strrpos($str, '-');
        $token = $lastDash !== false ? substr($str, $lastDash + 1) : $str;

        if (strlen($token) < 7) {
            return null;
        }

        $sig = strtolower(substr($token, 0, 6));
        $b36 = strtolower(substr($token, 6));

        if (! ctype_xdigit($sig) || ! ctype_alnum($b36)) {
            return null;
        }

        $key = (string) config('app.key', 'webuis-virtual-slug-secret');
        $mask = hexdec(substr(hash_hmac('sha256', 'mask:' . $sig, $key), 0, 5));
        $obfuscated = (int) base_convert($b36, 36, 10);
        $candidateId = $obfuscated ^ $mask;

        if ($candidateId <= 0) {
            return null;
        }

        $expectedSig = substr(hash_hmac('sha256', 'vslug:' . $candidateId, $key), 0, 6);
        if (! hash_equals($expectedSig, $sig)) {
            return null;
        }

        return $candidateId;
    }

    /**
     * Determine whether the given value is a signed non-numeric virtual slug.
     */
    public static function isSignedSlug(mixed $value): bool
    {
        if (! is_string($value) || $value === '' || ctype_digit($value)) {
            return false;
        }

        return self::decode($value) !== null;
    }

    /**
     * Generate a virtual slug for an Eloquent Model instance without storing it in the database.
     */
    public static function forModel(Model $model): string
    {
        $id = $model->getKey();
        if (! $id) {
            return '';
        }

        $class = get_class($model);
        $cacheKey = $class . ':' . $id;

        $title = self::extractTitle($model);
        $fallback = Str::kebab(class_basename($model));

        return self::$cache[$cacheKey] = self::encode((int) $id, $title, $fallback);
    }

    /**
     * Extract the most descriptive title/label attribute from a Model instance.
     */
    public static function extractTitle(Model $model): ?string
    {
        $attributes = $model->getAttributes();

        foreach (self::$titleAttributes as $attr) {
            if (! empty($attributes[$attr]) && is_string($attributes[$attr])) {
                return $attributes[$attr];
            }
        }

        return null;
    }

    /**
     * Generate a virtual slug for a route parameter when a raw numeric ID was passed to route().
     */
    public static function forRouteParam(string $routeName, string $paramName, int $id): string
    {
        $modelClass = self::resolveModelClass($routeName, $paramName);

        if ($modelClass && class_exists($modelClass)) {
            $cacheKey = $modelClass . ':' . $id;
            if (isset(self::$cache[$cacheKey])) {
                return self::$cache[$cacheKey];
            }

            try {
                /** @var Model|null $model */
                $model = $modelClass::find($id);
                if ($model) {
                    return self::forModel($model);
                }
            } catch (\Throwable $e) {
                // Fallback to generic encoding below
            }
        }

        $prefix = $paramName !== 'id' && $paramName !== 'slug'
            ? Str::kebab($paramName)
            : (explode('.', $routeName)[0] ?: 'item');

        return self::encode($id, null, $prefix);
    }

    /**
     * Map route names and parameter names to their corresponding Eloquent Model class.
     */
    protected static function resolveModelClass(string $routeName, string $paramName): ?string
    {
        $routeMap = [
            'homepage.galeri.detail'            => \App\Models\Gallery::class,
            'homepage.news.detail'              => \App\Models\News::class,
            'homepage.prestasi.detail'          => \App\Models\News::class,
            'homepage.fasilitas.detail'         => \App\Models\Sarana::class,
            'homepage.program-studi.detail'     => \App\Models\ProgramStudi::class,
            'homepage.layanan.detail'           => \App\Models\Layanan::class,
            'homepage.organisasi.detail'        => \App\Models\OrganisasiMahasiswa::class,
            'homepage.pengumuman-agenda.detail' => \App\Models\PengumumanAgenda::class,
            'homepage.pimpinan.detail'          => \App\Models\ProfilPimpinan::class,
        ];

        if (isset($routeMap[$routeName])) {
            return $routeMap[$routeName];
        }

        $prefix = explode('.', $routeName)[0] ?? '';

        $paramOrPrefixMap = [
            'user'                 => \App\Models\User::class,
            'gallery'              => \App\Models\Gallery::class,
            'profil'               => \App\Models\Profil::class,
            'contact'              => \App\Models\Contact::class,
            'news'                 => \App\Models\News::class,
            'pengumuman-agenda'    => \App\Models\PengumumanAgenda::class,
            'pengumumanAgenda'     => \App\Models\PengumumanAgenda::class,
            'faq'                  => \App\Models\Faq::class,
            'about'                => \App\Models\About::class,
            'unduhan'              => \App\Models\Unduhan::class,
            'desain-grafis'        => \App\Models\DesainGrafis::class,
            'desainGrafis'         => \App\Models\DesainGrafis::class,
            'pusat-informasi'      => \App\Models\PusatInformasiHumas::class,
            'pusatInformasi'       => \App\Models\PusatInformasiHumas::class,
            'template-dokumen'     => \App\Models\TemplateDokumen::class,
            'templateDokumen'      => \App\Models\TemplateDokumen::class,
            'milestone'            => \App\Models\Milestone::class,
            'kurikulum'            => \App\Models\Kurikulum::class,
            'banner'               => \App\Models\Banner::class,
            'layanan-terkait'      => \App\Models\LayananTerkait::class,
            'layanan_terkait'      => \App\Models\LayananTerkait::class,
            'social-media'         => \App\Models\SocialMedia::class,
            'socialMedia'          => \App\Models\SocialMedia::class,
            'feature'              => \App\Models\Feature::class,
            'sarana'               => \App\Models\Sarana::class,
            'tridharma'            => \App\Models\TriDharma::class,
            'tenaga-pendidik'      => \App\Models\TenagaPendidik::class,
            'tenaga_pendidik'      => \App\Models\TenagaPendidik::class,
            'testimonial'          => \App\Models\Testimonial::class,
            'prestasi'             => \App\Models\Prestasi::class,
            'organisasi-mahasiswa' => \App\Models\OrganisasiMahasiswa::class,
            'organisasi_mahasiswa' => \App\Models\OrganisasiMahasiswa::class,
            'program-studi'        => \App\Models\ProgramStudi::class,
            'programStudi'         => \App\Models\ProgramStudi::class,
            'dosen'                => \App\Models\Dosen::class,
            'topbar'               => \App\Models\Topbar::class,
            'manajemen'            => \App\Models\PimpinanManajemen::class,
            'struktur-organisasi'  => \App\Models\ProfilPimpinan::class,
            'struktur_organisasi'  => \App\Models\ProfilPimpinan::class,
            'partner'              => \App\Models\Partner::class,
            'visimisi'             => \App\Models\VisiMisi::class,
            'nilaiperusahaan'      => \App\Models\NilaiPerusahaan::class,
            'faculty-stat'         => \App\Models\FacultyStat::class,
            'faculty_stat'         => \App\Models\FacultyStat::class,
            'bahasa'               => \App\Models\BahasaSetting::class,
        ];

        return $paramOrPrefixMap[$paramName] ?? $paramOrPrefixMap[$prefix] ?? null;
    }
}

