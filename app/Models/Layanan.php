<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasVirtualSlug;

    protected $table = 'layanans';

    protected $fillable = [
        'icon',
        'judul',
        'dasar_hukum',
        'link',
        'deskripsi',
        'rincian',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
