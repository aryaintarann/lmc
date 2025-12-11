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
}
