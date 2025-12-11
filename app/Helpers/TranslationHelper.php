<?php

namespace App\Helpers;

use App\Services\TranslationService;

class TranslationHelper
{
    /**
     * Auto-translate missing language fields
     * 
     * @param array $data Request data with translatable fields
     * @param array $fields List of field names to check (e.g., ['title', 'description'])
     * @param TranslationService $translationService
     * @return array Data with all translations filled
     */
    public static function autoTranslateFields(array $data, array $fields, TranslationService $translationService): array
    {
        $locales = ['id', 'en'];
        
        foreach ($fields as $field) {
            // Skip if field doesn't exist in data
            if (!isset($data[$field]) || !is_array($data[$field])) {
                continue;
            }
            
            // Check which locales are missing or empty
            $missingLocales = [];
            $sourceLocale = null;
            $sourceText = null;
            
            foreach ($locales as $locale) {
                $text = trim($data[$field][$locale] ?? '');
                
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
                    try {
                        $translatedText = $translationService->translate(
                            $sourceText,
                            $sourceLocale,
                            $targetLocale
                        );
                        
                        // Set translated text in data
                        $data[$field][$targetLocale] = $translatedText;
                        
                        \Log::info("Auto-translated {$field} in controller", [
                            'from' => $sourceLocale,
                            'to' => $targetLocale,
                            'chars' => strlen($sourceText),
                        ]);
                        
                    } catch (\Exception $e) {
                        \Log::error("Translation failed for {$field}", [
                            'error' => $e->getMessage(),
                        ]);
                        // If translation fails, set empty string to avoid errors
                        $data[$field][$targetLocale] = '';
                    }
                }
            }
        }
        
        return $data;
    }
}
