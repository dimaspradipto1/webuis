<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SambutanDekan extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'sambutan_dekans';

    protected $fillable = [
        'nama_dekan',
        'jabatan_dekan',
        'foto_dekan',
        'kutipan_singkat',
        'sambutan_dekan',
    ];
}
