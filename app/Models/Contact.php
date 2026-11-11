<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    protected $table = 'contacts';

    protected $fillable = [
        'latitude',
        'longitude',
        'map',
        'no_wa',
        'email',
        'alamat',
    ];
}
