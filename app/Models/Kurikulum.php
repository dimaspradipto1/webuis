<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kurikulum extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'kurikulums';

    protected $fillable = [
        'layanan_id',
        'prodi_nama',
        'kode_mk',
        'nama_mk',
        'semester',
        'sks',
        'kategori',
        'file_rps',
        'link_rps',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    public function getRpsUrlAttribute(): ?string
    {
        if (! empty($this->file_rps)) {
            return asset('storage/'.$this->file_rps);
        }
        if (! empty($this->link_rps)) {
            return $this->link_rps;
        }

        return null;
    }

    protected $casts = [
        'semester' => 'integer',
        'sks' => 'integer',
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function getSemesterRomawiAttribute(): string
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
        ];

        return $romawi[$this->semester] ?? (string) $this->semester;
    }
}
