<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PusatInformasiHumasSetting extends Model
{
    use \App\Models\Concerns\HasVirtualSlug;

    use HasFactory;

    protected $table = 'pusat_informasi_humas_settings';

    protected $fillable = [
        'judul_seksi',
        'subjudul_seksi',
    ];
}
