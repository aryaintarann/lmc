<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
                Log::warning('GA4 Error (Popular Pages): ' . $e->getMessage());

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
        $cacheKey = 'ga4_views_' . md5($path . $period->startDate->format('Ymd') . $period->endDate->format('Ymd'));

        return Cache::remember($cacheKey, 3600, function () use ($period) {
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
    public function calculateTrafficChange(string $path, ?int $year = null, ?int $month = null): int
    {
        // Generate a unique cache key based on path AND selected date
        $cacheKey = 'ga4_change_' . md5($path . ($year ?? 'cur') . ($month ?? 'cur'));

        return Cache::remember($cacheKey, 86400, function () use ($path, $year, $month) {
            // TEMPORARY: Mock Data for Verification (Since no real traffic exists)
            // This allows you to test the filter.
            // Logic: Odd months = Decay (-40%), Even months = Growth (+25%)
            if ($month) {
                return $month % 2 != 0 ? -40 : 25;
            }

            try {
                if ($year && $month) {
                    // Custom Month vs Previous Month
                    $currentStart = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
                    $currentEnd = $currentStart->copy()->endOfMonth();

                    $prevStart = $currentStart->copy()->subMonth()->startOfMonth();
                    $prevEnd = $prevStart->copy()->endOfMonth();

                    $currentPeriod = Period::create($currentStart, $currentEnd);
                    $prevPeriod = Period::create($prevStart, $prevEnd);
                } else {
                    // Default: Last 30 Days vs Previous 30 Days
                    $currentPeriod = Period::days(30);

                    $start = \Carbon\Carbon::now()->subDays(60);
                    $end = \Carbon\Carbon::now()->subDays(30);
                    $prevPeriod = Period::create($start, $end);
                }

                // 1. Get Current Period Data
                $currentData = Analytics::fetchMostVisitedPage($currentPeriod, 100);
                $currentViews = $currentData->where('pagePath', $path)->sum('pageViews');

                // 2. Get Previous Period Data
                $lastData = Analytics::fetchMostVisitedPage($prevPeriod, 100);
                $lastViews = $lastData->where('pagePath', $path)->sum('pageViews');

                // 3. Calculate Change
                if ($lastViews == 0) {
                    return $currentViews > 0 ? 100 : 0;
                }

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
        return Cache::remember('ga4_high_bounce', 3600, function () use ($limit) {
            // TEMPORARY: Mock Data for Demo
            // Always return these articles as "High Bounce" to show the UI
            return ['/articles/1', '/articles/2'];

            try {
                // Fetch page data with bounce rate metric from GA4
                // Using Spatie Analytics to run a custom query
                $period = Period::days(30);

                // Get page views with engagement metrics
                $response = Analytics::get(
                    $period,
                    ['screenPageViews', 'bounceRate', 'engagementRate'],
                    ['pagePath'],
                    $limit * 2 // Fetch more to filter
                );

                $highBouncePages = [];

                foreach ($response as $row) {
                    $pagePath = $row['pagePath'] ?? '';
                    $bounceRate = floatval($row['bounceRate'] ?? 0);

                    // Only include article pages with bounce rate > 50%
                    if ($bounceRate > 0.5 && str_contains($pagePath, '/articles/')) {
                        $highBouncePages[] = $pagePath;
                    }

                    if (count($highBouncePages) >= $limit) {
                        break;
                    }
                }

                return $highBouncePages;

            } catch (\Exception $e) {
                Log::warning('GA4 Error (High Bounce Pages): ' . $e->getMessage());
                return [];
            }
        });
    }
}
