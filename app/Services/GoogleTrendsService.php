<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GoogleTrendsService
{
    /**
     * Fetch daily trending searches from Google Trends RSS Feed.
     * 
     * @param string $geo Country code (default: ID for Indonesia)
     * @return array List of trending keywords
     */
    public function fetchDailyTrends(string $geo = 'ID'): array
    {
        // Cache API calls for 1 hour to prevent abuse
        return Cache::remember("google_trends_{$geo}", 3600, function () use ($geo) {
            try {
                // Google Trends Daily Search Trends RSS
                $rssUrl = "https://trends.google.com/trends/trendingsearches/daily/rss?geo={$geo}";

                $response = Http::timeout(10)->get($rssUrl);

                if ($response->failed()) {
                    Log::error("Failed to fetch Google Trends RSS: " . $response->body());
                    return [];
                }

                $xml = simplexml_load_string($response->body());
                if ($xml === false) {
                    Log::error("Failed to parse Google Trends XML");
                    return [];
                }

                $keywords = [];
                // Parse Atom/RSS feed structure matches
                // Usually <item><title>...</title>...<ht:news_item_title>...</ht:news_item_title>
                // We'll target the main title of the trend item
                foreach ($xml->channel->item as $item) {
                    $keywords[] = (string) $item->title;
                }

                return array_slice($keywords, 0, 20); // Return top 20 trends

            } catch (\Exception $e) {
                Log::error("Google Trends Service Error: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Placeholder for 'Related Queries' (Phase 2)
     */
    public function fetchRelatedQueries(string $topic)
    {
        // Implementation for Phase 2
        return [];
    }
}
