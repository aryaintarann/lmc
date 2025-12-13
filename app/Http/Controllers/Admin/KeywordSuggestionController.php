<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleTrendsService;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class KeywordSuggestionController extends Controller
{
    protected $trendsService;
    protected $translationService;

    public function __construct(GoogleTrendsService $trendsService, TranslationService $translationService)
    {
        $this->trendsService = $trendsService;
        $this->translationService = $translationService;
    }

    public function suggest(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|min:2'
        ]);

        $topic = $request->input('topic');

        // 1. Fetch Suggestions for ID (Use original topic)
        $suggestionsID = $this->trendsService->fetchRelatedQueries($topic, 'id');

        // 2. Fetch Suggestions for EN (Translate topic first if needed)
        try {
            $topicEN = $this->translationService->translate($topic, 'id', 'en');
        } catch (\Exception $e) {
            $topicEN = $topic; // Fallback
        }

        $suggestionsEN = $this->trendsService->fetchRelatedQueries($topicEN, 'en');

        /**
         * Title Generator Logic:
         * Prioritize "Long-Tail Keywords" (>= 4 words) from Google Data.
         * These act as natural, high-intent titles.
         */
        $processTitles = function ($keywords, $lang) {
            $titles = [];
            // Expanded Blacklist to remove dictionary/irrelevant intents
            $bannedWords = [
                'video',
                'youtube',
                'mp3',
                'download',
                'gambar',
                'image',
                'pics',
                'band',
                'lyrics',
                'chord',
                'lirik',
                'kord',
                'lagu',
                'meaning',
                'pronunciation',
                'definition',
                'arti',
                'maksud',
                'pengucapan',
                'translate',
                'terjemahan',
                'wallpaper',
                'hot',
                'sex'
            ];

            foreach ($keywords as $k) {
                // Skip if contains banned words
                foreach ($bannedWords as $bad) {
                    if (stripos($k, $bad) !== false)
                        continue 2;
                }

                $wordCount = str_word_count($k);

                // Strategy 1: Real Long-Tail Queries (High Value) -> >= 4 Words
                // e.g. "How long does dengue fever last"
                if ($wordCount >= 4) {
                    $titles[] = ucwords($k);
                    continue;
                }

                // Strategy 2: Question keywords (High Intent) -> >= 3 Words
                $isQuestion = preg_match('/^(apa|kenapa|bagaimana|siapa|kapan|how|why|what|when|who|cara|tips|is|are|can|does)/i', $k);
                if ($wordCount >= 3 && $isQuestion) {
                    $titles[] = ucwords($k);
                    continue;
                }

                // Strategy 3: Short but valuable keywords (3 words) -> Use Template
                // e.g. "Dengue fever symptoms" -> Wraps in template
                if ($wordCount == 3) {
                    $baseKeyword = ucwords($k);
                    if ($lang === 'en') {
                        $titles[] = "Complete Guide: $baseKeyword";
                        $titles[] = "All You Need to Know About $baseKeyword";
                    } else {
                        $titles[] = "Panduan Lengkap: $baseKeyword";
                        $titles[] = "Fakta Penting Tentang $baseKeyword";
                    }
                }
            }

            // Remove duplicates and limit
            $titles = array_unique($titles);
            return array_slice($titles, 0, 8);
        };

        $titlesID = $processTitles($suggestionsID, 'id');
        $titlesEN = $processTitles($suggestionsEN, 'en');

        return response()->json([
            'topic' => $topic,
            'id' => [
                'suggestions' => $suggestionsID,
                'titles' => $titlesID
            ],
            'en' => [
                'suggestions' => $suggestionsEN,
                'titles' => $titlesEN
            ]
        ]);
    }
}
