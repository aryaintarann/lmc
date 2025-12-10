<?php

namespace App\Traits;

use Stichoza\GoogleTranslate\GoogleTranslate;

trait AutoTranslates
{
    public static function bootAutoTranslates()
    {
        static::saving(function ($model) {
            $locales = ['en', 'id']; // Supported locales
            $translatable = $model->translatable ?? [];

            foreach ($translatable as $attribute) {
                $translations = $model->getTranslations($attribute);

                // Skip if no translations exist
                if (empty($translations)) {
                    continue;
                }

                // Identify available and missing locales
                $available = array_keys($translations);
                $missing = array_diff($locales, $available);

                if (empty($missing)) {
                    continue;
                }

                // Determine source locale (prefer current app locale, then 'en', then first available)
                $sourceLocale = app()->getLocale();
                if (!in_array($sourceLocale, $available)) {
                    $sourceLocale = in_array('en', $available) ? 'en' : $available[0];
                }

                $sourceText = $translations[$sourceLocale];

                // Translate to missing locales
                $tr = new GoogleTranslate();
                $tr->setSource($sourceLocale);

                foreach ($missing as $targetLocale) {
                    try {
                        $tr->setTarget($targetLocale);
                        $translatedText = $tr->translate($sourceText);
                        $model->setTranslation($attribute, $targetLocale, $translatedText);
                    } catch (\Exception $e) {
                        // Log error or silently fail? Silent for now to avoid breaking save.
                        // \Log::error("Translation failed for $attribute: " . $e->getMessage());
                    }
                }
            }
        });
    }
}
