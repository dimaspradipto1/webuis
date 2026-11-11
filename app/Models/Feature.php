<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'features';

    protected $fillable = [
        'icon',
        'judul',
        'deskripsi',
        'urutan',
    ];
}
