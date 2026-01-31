<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Contact extends Model
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address',
        'phone',
        'email',
        'operating_hours',
        'whatsapp',
        'maps_embed',
        'facebook',
        'instagram',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'address' => 'array',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['operating_hours'];
}
