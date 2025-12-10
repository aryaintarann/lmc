<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\AutoTranslates;

class Service extends Model
{
    use HasTranslations, AutoTranslates;

    protected $guarded = [];

    public $translatable = ['title', 'description'];
}
