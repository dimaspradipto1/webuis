<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasVirtualSlug;

    protected $table = 'prestasis';

    protected $fillable = [
        'foto',
        'judul_prestasi',
        'nama_mahasiswa',
        'nim',
        'prodi',
        'tingkat',
        'peringkat',
        'penyelenggara',
        'tahun',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];
}
