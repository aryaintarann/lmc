<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\Doctor;
use App\Models\Article;
use App\Observers\AutoTranslateObserver;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Auto-Translate Observer for models with translatable fields
        Service::observe(AutoTranslateObserver::class);
        Doctor::observe(AutoTranslateObserver::class);
        Article::observe(AutoTranslateObserver::class);
    }
}
