<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrganisasiMahasiswa extends Model
{
    use HasVirtualSlug;
    protected $table = 'organisasi_mahasiswas';

    protected $fillable = [
        'nama_organisasi',
        'singkatan',
        'slug',
        'kategori',
        'deskripsi',
        'visi',
        'misi',
        'nama_ketua',
        'nama_wakil',
        'pembina',
        'periode',
        'logo',
        'foto_kegiatan',
        'instagram',
        'email',
        'link_pendaftaran',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $base = ! empty($model->singkatan) ? $model->singkatan : $model->nama_organisasi;
                $slug = Str::slug($base);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                $model->slug = $slug;
            }
        });
    }
}
