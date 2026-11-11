<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'partners';

    protected $fillable = [
        'nama',
        'logo',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
