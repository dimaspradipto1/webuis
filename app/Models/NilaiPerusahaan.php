<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiPerusahaan extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'nilai_perusahaans';

    protected $fillable = [
        'icon',
        'judul',
        'deskripsi',
        'urutan',
    ];
}
