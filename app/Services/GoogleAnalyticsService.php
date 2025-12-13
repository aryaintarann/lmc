<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
// use Analytics; // Requires spatie/laravel-analytics
// use Spatie\Analytics\Period;

class GoogleAnalyticsService
{
    /**
     * Fetch most visited pages from GA4.
     * 
     * @param int $days Number of days to look back
     * @param int $limit Number of results
     * @return array List of slugs (e.g., ['/articles/foo', '/articles/bar'])
     */
    public function getMostPopularPages(int $days = 2, int $limit = 20): array
    {
        // Cache for 4 hours
        return Cache::remember("ga4_popular_pages_{$days}d", 14400, function () use ($days, $limit) {
            try {
                // TODO: Uncomment this when Spatie Analytics is configured
                // $analyticsData = Analytics::fetchMostVisitedPage(Period::days($days), $limit);
                // return $analyticsData->pluck('pagePath')->toArray();

                // --- MOCK DATA FOR DEVELOPMENT ---
                // If GA4 is not connected yet, return empty or mock data
                Log::warning("GA4 Service is using MOCK data. Configure 'spatie/laravel-analytics' to use real data.");

                return [
                    // '/articles/example-slug-1',
                    // '/articles/example-slug-2'
                ];

            } catch (\Exception $e) {
                Log::error("Google Analytics Service Error: " . $e->getMessage());
                return [];
            }
        });
    }
}
