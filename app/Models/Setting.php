<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\AutoTranslates;

class Setting extends Model
{
    use HasTranslations, AutoTranslates;

    protected $guarded = [];

    public $translatable = ['value'];
}
