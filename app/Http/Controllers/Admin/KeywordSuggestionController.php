<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SuggestKeywordRequest;
use App\Services\GoogleTrendsService;
use App\Services\TitleGeneratorService;
use App\Services\TranslationService;

class KeywordSuggestionController extends Controller
{
    public function __construct(
        protected GoogleTrendsService $trendsService,
        protected TranslationService $translationService,
        protected TitleGeneratorService $titleGeneratorService
    ) {
    }

    public function __invoke(SuggestKeywordRequest $request)
    {
        $topic = $request->input('topic');

        // 1. Fetch Suggestions for ID
        $suggestionsID = $this->trendsService->fetchRelatedQueries($topic, 'id');

        // 2. Fetch Suggestions for EN (Translate topic first if needed)
        try {
            $topicEN = $this->translationService->translate($topic, 'id', 'en');
        } catch (\Exception $e) {
            $topicEN = $topic; // Fallback
        }

        $suggestionsEN = $this->trendsService->fetchRelatedQueries($topicEN, 'en');

        // 3. Generate Titles
        $titlesID = $this->titleGeneratorService->generate($suggestionsID, 'id');
        $titlesEN = $this->titleGeneratorService->generate($suggestionsEN, 'en');

        // 4. Return JSON directly (not wrapped in Resource to match frontend expectations)
        return response()->json([
            'topic' => $topic,
            'id' => [
                'suggestions' => $suggestionsID,
                'titles' => $titlesID,
            ],
            'en' => [
                'suggestions' => $suggestionsEN,
                'titles' => $titlesEN,
            ],
        ]);
    }
}
