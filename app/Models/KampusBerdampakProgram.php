<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KampusBerdampakProgram extends Model
{
    use HasFactory;

    protected $table = 'kampus_berdampak_programs';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];
}
