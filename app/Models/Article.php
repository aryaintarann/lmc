<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : '';
    }
}
