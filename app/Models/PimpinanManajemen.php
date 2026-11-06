<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanManajemen extends Model
{
    use HasFactory;

    protected $table = 'pimpinan_manajemens';

    protected $fillable = [
        'kategori',
        'no_urut',
        'nama',
        'jabatan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

