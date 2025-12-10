<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;
use App\Traits\AutoTranslates;

class Article extends Model
{
    use HasTranslations, AutoTranslates;

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
