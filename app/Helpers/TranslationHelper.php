<?php

namespace App\Helpers;

use App\Services\TranslationService;

class TranslationHelper
{
    /**
     * Auto-translate missing language fields
     *
     * @param  array  $data  Request data with translatable fields
     * @param  array  $fields  List of field names to check (e.g., ['title', 'description'])
     * @return array Data with all translations filled
     */
    public static function autoTranslateFields(array $data, array $fields, TranslationService $translationService): array
    {
        $locales = ['id', 'en'];

        foreach ($fields as $field) {
            // Skip if field doesn't exist in data
            if (! isset($data[$field]) || ! is_array($data[$field])) {
                continue;
            }

            // Check which locales are missing or empty
            $missingLocales = [];
            $sourceLocale = null;
            $sourceText = null;

            foreach ($locales as $locale) {
                $text = trim($data[$field][$locale] ?? '');

                // Enhanced check for "empty" content (handling WYSIWYG empty states like <p><br></p>)
                $isEmpty = false;
                if (empty($text)) {
                    $isEmpty = true;
                } else {
                    // Strip tags and whitespace
                    $cleanText = trim(strip_tags(html_entity_decode($text)));
                    // Check if it really has text or critical media tags
                    if (
                        empty($cleanText) &&
                        ! str_contains($text, '<img') &&
                        ! str_contains($text, '<iframe') &&
                        ! str_contains($text, '<video')
                    ) {
                        $isEmpty = true;
                    }
                }

                if ($isEmpty) {
                    $missingLocales[] = $locale;
                } elseif ($sourceText === null) {
                    // Use first non-empty locale as source
                    $sourceLocale = $locale;
                    $sourceText = $text;
                }
            }

            // If we have source text and missing locales, translate
            if ($sourceText && ! empty($missingLocales)) {
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
