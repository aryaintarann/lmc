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
