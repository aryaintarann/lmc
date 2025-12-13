<?php

namespace App\Services;

use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translate;
    protected $projectId;
    protected $location = 'global';
    protected $cacheEnabled = true;
    protected $cacheDuration = 60 * 24 * 30; // 30 days in minutes

    public function __construct()
    {
        try {
            $keyFilePath = storage_path('app/' . config('services.google_cloud.key_file'));
            $this->projectId = config('services.google_cloud.project_id');

            if (!file_exists($keyFilePath)) {
                Log::warning('Google Cloud key file not found: ' . $keyFilePath);
                $this->translate = null;
                return;
            }

            $this->translate = new TranslationServiceClient([
                'credentials' => $keyFilePath,
                'transport' => 'rest',
                'transportConfig' => [
                    'rest' => [
                        'http' => [
                            'verify' => false
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Google Cloud Translation initialization failed: ' . $e->getMessage());
            $this->translate = null;
        }
    }

    /**
     * Translate a single text
     *
     * @param string $text Text to translate
     * @param string $sourceLang Source language code (e.g., 'en', 'id')
     * @param string $targetLang Target language code
     * @return string Translated text or original text if translation fails
     */
    public function translate(string $text, string $sourceLang, string $targetLang): string
    {
        // If same language, return original
        if ($sourceLang === $targetLang) {
            return $text;
        }

        // If text is empty, return as is
        if (empty(trim($text))) {
            return $text;
        }

        // Check cache first
        if ($this->cacheEnabled) {
            $cacheKey = $this->getCacheKey($text, $sourceLang, $targetLang);
            $cached = Cache::get($cacheKey);

            if ($cached !== null) {
                return $cached;
            }
        }

        // If translation client is not available, return original text
        if (!$this->translate) {
            Log::warning('Translation client not available, returning original text');
            return $text;
        }

        try {
            $parent = $this->translate->locationName($this->projectId, $this->location);

            // Create request object
            $request = new TranslateTextRequest([
                'parent' => $parent,
                'contents' => [$text],
                'target_language_code' => $targetLang,
                'source_language_code' => $sourceLang,
            ]);

            $response = $this->translate->translateText($request);

            $translations = $response->getTranslations();
            $translatedText = $translations[0]->getTranslatedText() ?? $text;

            // Cache the result
            if ($this->cacheEnabled) {
                $cacheKey = $this->getCacheKey($text, $sourceLang, $targetLang);
                Cache::put($cacheKey, $translatedText, $this->cacheDuration);
            }

            return $translatedText;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => $text,
                'source' => $sourceLang,
                'target' => $targetLang,
            ]);

            // Return original text on error
            return $text;
        }
    }

    /**
     * Translate multiple texts at once (more efficient)
     *
     * @param array $texts Array of texts to translate
     * @param string $sourceLang Source language code
     * @param string $targetLang Target language code
     * @return array Array of translated texts (maintains order)
     */
    public function translateBatch(array $texts, string $sourceLang, string $targetLang): array
    {
        // If same language, return original
        if ($sourceLang === $targetLang) {
            return $texts;
        }

        $results = [];
        $toTranslate = [];
        $toTranslateIndexes = [];

        // Check cache for each text
        foreach ($texts as $index => $text) {
            if (empty(trim($text))) {
                $results[$index] = $text;
                continue;
            }

            if ($this->cacheEnabled) {
                $cacheKey = $this->getCacheKey($text, $sourceLang, $targetLang);
                $cached = Cache::get($cacheKey);

                if ($cached !== null) {
                    $results[$index] = $cached;
                    continue;
                }
            }

            // Not in cache, add to translation queue
            $toTranslate[] = $text;
            $toTranslateIndexes[] = $index;
        }

        // If nothing to translate, return results
        if (empty($toTranslate)) {
            return $results;
        }

        // If translation client is not available, return original texts
        if (!$this->translate) {
            foreach ($toTranslateIndexes as $i => $index) {
                $results[$index] = $toTranslate[$i];
            }
            return $results;
        }

        try {
            // v3 API: Translate all at once using contents array
            $parent = $this->translate->locationName($this->projectId, $this->location);

            // Create request object
            $request = new TranslateTextRequest([
                'parent' => $parent,
                'contents' => $toTranslate,
                'target_language_code' => $targetLang,
                'source_language_code' => $sourceLang,
            ]);

            $response = $this->translate->translateText($request);

            $translations = $response->getTranslations();

            // Process results
            foreach ($translations as $i => $translation) {
                $index = $toTranslateIndexes[$i];
                $originalText = $toTranslate[$i];
                $translatedText = $translation->getTranslatedText() ?? $originalText;

                $results[$index] = $translatedText;

                // Cache the result
                if ($this->cacheEnabled) {
                    $cacheKey = $this->getCacheKey($originalText, $sourceLang, $targetLang);
                    Cache::put($cacheKey, $translatedText, $this->cacheDuration);
                }
            }
        } catch (\Exception $e) {
            Log::error('Batch translation failed: ' . $e->getMessage());

            // Return original texts on error
            foreach ($toTranslateIndexes as $i => $index) {
                $results[$index] = $toTranslate[$i];
            }
        }

        return $results;
    }

    /**
     * Generate cache key for translation
     *
     * @param string $text
     * @param string $sourceLang
     * @param string $targetLang
     * @return string
     */
    protected function getCacheKey(string $text, string $sourceLang, string $targetLang): string
    {
        return 'translation:' . md5($text . '|' . $sourceLang . '|' . $targetLang);
    }
}
