<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function agreements(): HasMany
    {
        return $this->hasMany(PartnerAgreement::class);
    }
}
