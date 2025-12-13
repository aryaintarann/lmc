<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TrendAnalysisService
{
    protected $trendsService;
    protected $analyticsService;

    public function __construct(GoogleTrendsService $trendsService, GoogleAnalyticsService $analyticsService)
    {
        $this->trendsService = $trendsService;
        $this->analyticsService = $analyticsService;
    }

    /**
     * Analyze data and update 'trend_score' for all articles.
     */
    public function analyzeAndUpdateScores()
    {
        $startTime = microtime(true);
        Log::info("Starting Trend Analysis...");

        // 1. Fetch External Data
        $trendingKeywords = $this->trendsService->fetchDailyTrends(); // e.g. ['Flu', 'Vitamin']
        $popularSlugs = $this->analyticsService->getMostPopularPages(); // e.g. ['/articles/flu']

        Log::info("Fetched " . count($trendingKeywords) . " trending keywords and " . count($popularSlugs) . " popular pages.");

        // 2. Process Articles
        // Chunking to handle large datasets
        Article::chunk(100, function ($articles) use ($trendingKeywords, $popularSlugs) {
            foreach ($articles as $article) {
                $score = 0;
                $matches = [];

                // A. Google Trends Logic (+50)
                foreach ($trendingKeywords as $keyword) {
                    if (stripos($article->title, $keyword) !== false) {
                        $score += 50;
                        $matches[] = "Matched Trend: $keyword";
                        break; // Max one trend match bonus
                    }
                }

                // B. Popularity Logic (+30)
                // Assuming slug is just the last part, flexible match
                $articleSlug = $article->slug ?? '';
                foreach ($popularSlugs as $pagePath) {
                    if (str_contains($pagePath, $articleSlug) && !empty($articleSlug)) {
                        $score += 30;
                        $matches[] = "Matched Analytics: $pagePath";
                        break;
                    }
                }

                // C. Freshness Logic (+10)
                if ($article->created_at > Carbon::now()->subDays(7)) {
                    $score += 10;
                    $matches[] = "Fresh Content (< 7 days)";
                }

                // Update Database
                // Only update if score changed to reduce DB writes
                if ($article->trend_score != $score) {
                    $article->update([
                        'trend_score' => $score,
                        'trend_data' => !empty($matches) ? json_encode($matches) : null
                    ]);
                }
            }
        });

        $duration = round(microtime(true) - $startTime, 2);
        Log::info("Trend Analysis completed in {$duration}s.");
    }
}
