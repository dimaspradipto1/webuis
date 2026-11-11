<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProfilPimpinan extends Model
{
    use HasFactory, HasVirtualSlug;

    protected $table = 'profil_pimpinans';

    protected $fillable = [
        'nama',
        'slug',
        'jabatan',
        'baris',
        'foto',
        'galeri',
        'biografi',
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

        static::saving(function (self $pimpinan) {
            if (empty($pimpinan->slug) && ! empty($pimpinan->nama)) {
                $baseSlug = Str::slug($pimpinan->nama) ?: 'pimpinan';
                $slug = $baseSlug;
                $counter = 2;

                while (static::where('slug', $slug)->where('id', '!=', $pimpinan->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$counter++;
                }

                $pimpinan->slug = $slug;
            }
        });
    }

    public function getFotoUrlAttribute(): string
    {
        if (empty($this->foto)) {
            return asset('assets/img/logouis.png');
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
}

