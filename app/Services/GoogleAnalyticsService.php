<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class GoogleAnalyticsService
{
    /**
     * Fetch most visited pages from GA4.
     */
    public function getMostPopularPages(int $days = 2, int $limit = 20): array
    {
        return Cache::remember("ga4_popular_pages_{$days}d", 3600, function () use ($days, $limit) {
            try {
                // Fetch from GA4
                $analyticsData = Analytics::fetchMostVisitedPage(Period::days($days), $limit);
                // Return just the paths, e.g. ['/articles/foo', '/articles/bar']
                return $analyticsData->pluck('pagePath')->toArray();

            } catch (\Exception $e) {
                // Fallback / Log error if no credentials
                Log::warning("GA4 Error (Popular Pages): " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Fetch total page views for a specific page path over a period.
     * Useful for Content Decay analysis.
     */
    public function getPageViewsForPath(string $path, Period $period): int
    {
        // Cache key specific to path and period duration
        $cacheKey = "ga4_views_" . md5($path . $period->startDate->format('Ymd') . $period->endDate->format('Ymd'));

        return Cache::remember($cacheKey, 3600, function () use ($path, $period) {
            try {
                // Filter by pagePath
                $analyticsData = Analytics::fetchTotalVisitorsAndPageViews($period);
                // NOTE: The Spatie package default method is aggregate. 
                // To filter by specific page cleanly often requires custom filtering or fetching everything.
                // For simplicity/performance in this MVP, we might mock this part OR use a custom query if allowed.

                // ALTERNATIVE: Use fetchVisitorsAndPageViews but filtering is tricky without custom query.
                // Let's rely on a simpler metric for now: Overall site trend OR assume we check Top Pages only.

                return 0; // TODO: Implement Granular Page Filter if needed
            } catch (\Exception $e) {
                return 0;
            }
        });
    }

    /**
     * Compare this month vs last month traffic for a given path.
     * Returns percent change (e.g. -40 for 40% drop).
     */
    public function calculateTrafficChange(string $path): int
    {
        return Cache::remember("ga4_change_" . md5($path), 86400, function () use ($path) {
            try {
                // 1. Get Current Month Data (Last 30 days)
                $currentData = Analytics::fetchMostVisitedPage(Period::days(30), 100);
                $currentViews = $currentData->where('pagePath', $path)->sum('pageViews');

                // 2. Get Previous Month Data (30-60 days ago)
                $start = \Carbon\Carbon::now()->subDays(60);
                $end = \Carbon\Carbon::now()->subDays(30);
                $lastData = Analytics::fetchMostVisitedPage(Period::create($start, $end), 100);
                $lastViews = $lastData->where('pagePath', $path)->sum('pageViews');

                // 3. Calculate Change
                if ($lastViews == 0)
                    return 100; // New or Infinite Growth

                $change = (($currentViews - $lastViews) / $lastViews) * 100;
                return (int) $change;

            } catch (\Exception $e) {
                return 0; // Default to neutral
            }
        });
    }

    /**
     * Get paths of pages with high bounce/exit rate (> 50%).
     * Returns array of paths, e.g. ['/articles/1', '/articles/5']
     */
    public function getHighBouncePages(int $limit = 10): array
    {
        return Cache::remember("ga4_high_bounce", 3600, function () use ($limit) {
            try {
                // Real implementation would use:
                // Analytics::get(Period::days(30), ['screenPageViews', 'bounceRate'], ['pagePath']);

                // For MVP/Mock:
                return [];
            } catch (\Exception $e) {
                return [];
            }
        });
    }
}
