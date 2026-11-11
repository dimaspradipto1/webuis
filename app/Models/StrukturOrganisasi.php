<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'struktur_organisasis';

    protected $fillable = [
        'url_struktur',
    ];
}
