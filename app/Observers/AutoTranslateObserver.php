<?php

namespace App\Observers;

use App\Services\TranslationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AutoTranslateObserver
{
    protected $translationService;
    protected $translatedInCurrentRequest = [];

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Handle the Model "retrieved" event.
     * Auto-translate missing translations when a model is retrieved
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function retrieved(Model $model)
    {
        // Skip if model doesn't have translatable fields
        if (!property_exists($model, 'translatable') || empty($model->translatable)) {
            return;
        }

        $currentLocale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'id');

        // Skip if current locale is the fallback locale
        if ($currentLocale === $fallbackLocale) {
            return;
        }

        // Skip if already translated in this request (avoid duplicate API calls)
        $modelKey = get_class($model) . '_' . $model->getKey();
        if (isset($this->translatedInCurrentRequest[$modelKey])) {
            return;
        }

        $hasChanges = false;

        // Check each translatable attribute
        foreach ($model->translatable as $attribute) {
            try {
                $translations = $model->getTranslations($attribute);
                
                // Skip if translation already exists for current locale
                if (!empty($translations[$currentLocale])) {
                    continue;
                }

                // Skip if no source text available
                if (empty($translations[$fallbackLocale])) {
                    continue;
                }

                $sourceText = $translations[$fallbackLocale];
                
                // Skip empty or whitespace-only text
                if (trim($sourceText) === '') {
                    continue;
                }

                // Translate automatically
                $translatedText = $this->translationService->translate(
                    $sourceText,
                    $fallbackLocale,
                    $currentLocale
                );

                // Quality check: if translation is identical to source, might be an error
                // But still use it (could be proper noun or already in target language)
                if ($translatedText === $sourceText) {
                    Log::info("Translation returned same text for {$attribute}", [
                        'model' => get_class($model),
                        'id' => $model->getKey(),
                        'text' => substr($sourceText, 0, 50),
                    ]);
                }

                // Set the translation
                $model->setTranslation($attribute, $currentLocale, $translatedText);
                $hasChanges = true;

                Log::info("Auto-translated {$attribute}", [
                    'model' => get_class($model),
                    'id' => $model->getKey(),
                    'from' => $fallbackLocale,
                    'to' => $currentLocale,
                    'chars' => strlen($sourceText),
                ]);

            } catch (\Exception $e) {
                Log::error("Auto-translation failed for {$attribute}", [
                    'model' => get_class($model),
                    'id' => $model->getKey(),
                    'error' => $e->getMessage(),
                ]);
                // Continue with other attributes even if one fails
            }
        }

        // Save translations to database for future use
        if ($hasChanges) {
            try {
                // Save without triggering events to avoid infinite loop
                $model->saveQuietly();
                
                // Mark as translated in this request
                $this->translatedInCurrentRequest[$modelKey] = true;
                
            } catch (\Exception $e) {
                Log::error("Failed to save auto-translations", [
                    'model' => get_class($model),
                    'id' => $model->getKey(),
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
