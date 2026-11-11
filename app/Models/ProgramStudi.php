<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProgramStudi extends Model
{
    use HasFactory, HasVirtualSlug;

    protected $table = 'program_studis';

    protected $fillable = [
        'nama',
        'slug',
        'jenjang',
        'fakultas',
        'icon',
        'akreditasi',
        'gelar',
        'deskripsi_singkat',
        'deskripsi',
        'visi',
        'misi',
        'prospek_karir',
        'foto',
        'galeri',
        'link_website',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'galeri' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $prodi) {
            if (empty($prodi->slug) && ! empty($prodi->nama)) {
                $baseSlug = Str::slug($prodi->nama) ?: 'program-studi';
                $slug = $baseSlug;
                $counter = 2;

                while (static::where('slug', $slug)->where('id', '!=', $prodi->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$counter++;
                }

                $prodi->slug = $slug;
            }
        });
    }

    public function getFotoUrlAttribute(): ?string
    {
        if (empty($this->foto)) {
            return null;
        }
        if (str_starts_with($this->foto, 'http')) {
            return $this->foto;
        }
        if (str_starts_with($this->foto, 'assets/')) {
            return asset($this->foto);
        }

        return asset('storage/'.$this->foto);
    }

    public function getAllPhotosAttribute(): array
    {
        $photos = [];
        if (! empty($this->foto)) {
            $photos[] = $this->foto;
        }
        if (is_array($this->galeri)) {
            foreach ($this->galeri as $img) {
                if (! empty($img) && ! in_array($img, $photos, true)) {
                    $photos[] = $img;
                }
            }
        }

        return $photos;
    }

    public function getAllPhotoUrlsAttribute(): array
    {
        return array_map(function ($path) {
            if (str_starts_with($path, 'http')) {
                return $path;
            }
            if (str_starts_with($path, 'assets/')) {
                return asset($path);
            }

            return asset('storage/'.$path);
        }, $this->all_photos);
    }

    public function getMisiListAttribute(): array
    {
        if (empty($this->misi)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $this->misi))));
    }

    public function getProspekListAttribute(): array
    {
        if (empty($this->prospek_karir)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $this->prospek_karir))));
    }
}

