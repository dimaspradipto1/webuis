<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'visi_misis';

    protected $fillable = [
        'tipe',
        'isi',
        'urutan',
    ];
}
