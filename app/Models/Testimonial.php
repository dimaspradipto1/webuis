<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'testimonials';

    protected $fillable = [
        'nama',
        'pekerjaan',
        'kategori',
        'bintang',
        'pesan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
