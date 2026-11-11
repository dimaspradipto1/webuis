<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasVirtualSlug;

    protected $table = 'news';

    protected $fillable = [
        'user_id',
        'thumbnail',
        'gallery',
        'title',
        'description',
        'content',
        'status',
        'category',
        'is_featured',
        'published_at',
        'created_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'gallery' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($news) {
            // Default tanggal publish ke now() jika tidak diisi
            if (empty($news->published_at)) {
                $news->published_at = now();
            }

            // Selaraskan created_at dengan published_at agar kompatibel dengan seluruh view frontend
            if (! empty($news->published_at)) {
                $news->created_at = $news->published_at;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
