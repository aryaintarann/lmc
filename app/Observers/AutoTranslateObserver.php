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
     * Handle the Model "saving" event.
     * Auto-translate missing translations BEFORE saving to database
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function saving(Model $model)
    {
        $this->autoTranslate($model);
    }

    /**
     * Handle the Model "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        $this->autoTranslate($model);
    }

    /**
     * Handle the Model "updating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updating(Model $model)
    {
        $this->autoTranslate($model);
    }

    /**
     * Auto-translate missing translations
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    protected function autoTranslate(Model $model)
    {
        // Skip if model doesn't have translatable fields
        if (!property_exists($model, 'translatable') || empty($model->translatable)) {
            return;
        }

        $locales = ['id', 'en'];
        
        // Check each translatable attribute
        foreach ($model->translatable as $attribute) {
            try {
                $translations = $model->getTranslations($attribute);
                
                // Check which locales are missing or empty
                $missingLocales = [];
                $sourceLocale = null;
                $sourceText = null;
                
                foreach ($locales as $locale) {
                    $text = trim($translations[$locale] ?? '');
                    
                    if (empty($text)) {
                        $missingLocales[] = $locale;
                    } else if ($sourceText === null) {
                        // Use first non-empty locale as source
                        $sourceLocale = $locale;
                        $sourceText = $text;
                    }
                }
                
                // If we have source text and missing locales, translate
                if ($sourceText && !empty($missingLocales)) {
                    foreach ($missingLocales as $targetLocale) {
                        $translatedText = $this->translationService->translate(
                            $sourceText,
                            $sourceLocale,
                            $targetLocale
                        );
                        
                        // Set translation directly on model
                        $model->setTranslation($attribute, $targetLocale, $translatedText);
                        
                        Log::info("Auto-translated {$attribute} on save", [
                            'model' => get_class($model),
                            'from' => $sourceLocale,
                            'to' => $targetLocale,
                            'chars' => strlen($sourceText),
                        ]);
                    }
                }

            } catch (\Exception $e) {
                Log::error("Auto-translation failed for {$attribute}", [
                    'model' => get_class($model),
                    'error' => $e->getMessage(),
                ]);
                // Continue with other attributes even if one fails
            }
        }
    }
}
