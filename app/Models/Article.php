<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['title', 'excerpt', 'content'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->getTranslation('title', 'en'));
            }
        });

        static::updating(function ($article) {
            // Only regenerate slug if title changed and slug is empty
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->getTranslation('title', 'en'));
            }
        });
    }

    /**
     * Generate unique slug from title
     */
    protected static function generateUniqueSlug($title)
    {
        $baseSlug = \Illuminate\Support\Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Use slug for route model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : '';
    }

    public function scopeTrending($query)
    {
        return $query->orderBy('trend_score', 'desc');
    }

    public function getProcessedContentAttribute()
    {
        // Resolve the service from the container
        $linkService = app(\App\Services\InternalLinkService::class);

        // Get the current translated content
        $content = $this->content;

        // Return processed content with internal links
        return $linkService->linkKeywords($content);
    }
}
