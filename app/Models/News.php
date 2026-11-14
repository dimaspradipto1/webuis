<?php

namespace App\Models;

use App\Models\Concerns\HasVirtualSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

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

        static::saved(function ($news) {
            $news->syncToGallery();
        });

        static::deleted(function ($news) {
            Gallery::where('news_id', $news->id)->delete();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function galleryRecord(): HasOne
    {
        return $this->hasOne(Gallery::class, 'news_id');
    }

    /**
     * Otomatis sinkronisasi gambar/galeri berita ke tabel Galeri Dokumentasi
     */
    public function syncToGallery(): void
    {
        $allPhotos = [];
        if (! empty($this->thumbnail)) {
            $allPhotos[] = $this->thumbnail;
        }
        if (is_array($this->gallery)) {
            foreach ($this->gallery as $p) {
                if (! empty($p) && ! in_array($p, $allPhotos, true)) {
                    $allPhotos[] = $p;
                }
            }
        }

        // Sinkronkan jika berita memiliki foto dan berstatus published
        if (! empty($allPhotos) && $this->status === 'published') {
            $katHumas = str_contains(strtolower($this->category ?? ''), 'humas');
            $mainUrl = $this->thumbnail ?: ($allPhotos[0] ?? null);

            Gallery::updateOrCreate(
                ['news_id' => $this->id],
                [
                    'judul' => $this->title,
                    'slug' => $this->slug,
                    'kategori' => $katHumas ? 'humas' : 'universitas',
                    'kategori_berita' => $this->category,
                    'deskripsi' => $this->description ?: Str::limit(strip_tags($this->content ?? ''), 150),
                    'url' => $mainUrl,
                    'galeri' => $allPhotos,
                    'created_at' => $this->published_at ?: ($this->created_at ?: now()),
                    'updated_at' => $this->updated_at ?: now(),
                ]
            );
        } else {
            Gallery::where('news_id', $this->id)->delete();
        }
    }
}
