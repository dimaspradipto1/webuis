<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerAgreement extends Model
{
    public const TYPES = ['MOU', 'MOA', 'IA'];

    protected $fillable = [
        'partner_id',
        'jenis',
        'judul',
        'nomor',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_path',
        'tautan',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'aktif' => 'boolean',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
