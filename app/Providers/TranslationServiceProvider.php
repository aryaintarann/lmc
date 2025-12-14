<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Doctor;
use App\Models\Header;
use App\Models\Service;
use App\Models\Setting;
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
        /**
         * NOTE: Observer-based auto-translation has been DISABLED.
         *
         * WHY: Observer events (saving/creating/updating) fire BEFORE Spatie Translatable
         * finalizes JSON storage. This causes timing issues where our translations get
         * overwritten with empty strings when the model is saved.
         *
         * SOLUTION: Auto-translation now happens in Controllers using TranslationHelper.
         * See: app/Helpers/TranslationHelper.php
         *
         * Controllers with auto-translation:
         * - ArticleController (store, update)
         * - ServiceController (store, update)
         * - SettingController (updateHeader, updateAbout, updateContact)
         */

        // Observer registrations removed - using controller-level translation instead
        // Article::observe(AutoTranslateObserver::class);
        // Service::observe(AutoTranslateObserver::class);
        // Doctor::observe(AutoTranslateObserver::class);
        // Header::observe(AutoTranslateObserver::class);
        // About::observe(AutoTranslateObserver::class);
        // Contact::observe(AutoTranslateObserver::class);
        // Setting::observe(AutoTranslateObserver::class);
    }
}
