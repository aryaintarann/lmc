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
     * Fetch related queries (autocomplete suggestions) for a topic.
     * 
     * @param string $topic Check for related keywords
     * @param string $lang Language code (id, en, etc.)
     * @return array List of suggestions
     */
    public function fetchRelatedQueries(string $topic, string $lang = 'id'): array
    {
        // V2 Cache Key to force refresh with new GL parameters
        return Cache::remember("google_suggest_v2_{$topic}_{$lang}", 3600, function () use ($topic, $lang) {
            try {
                // Map simple lang code to Google's hl (host language) and gl (geo location)
                $params = [
                    'id' => ['hl' => 'id', 'gl' => 'id'],
                    'en' => ['hl' => 'en', 'gl' => 'us'], // Global defaults to US English data
                ];

                $config = $params[$lang] ?? $params['en'];

                // Construct URL with proper localization
                $url = "http://google.com/complete/search?output=toolbar&q=" . urlencode($topic) . "&hl={$config['hl']}&gl={$config['gl']}";

                $response = Http::timeout(5)->get($url);

                if ($response->successful()) {
                    $xml = simplexml_load_string($response->body());
                    $suggestions = [];

                    if ($xml && isset($xml->CompleteSuggestion)) {
                        foreach ($xml->CompleteSuggestion as $suggestion) {
                            $suggestions[] = (string) $suggestion->suggestion['data'];
                        }
                    }

                    return $suggestions;
                }

                return [];
            } catch (\Exception $e) {
                Log::error("Google Trends Autocomplete Error: " . $e->getMessage());
                return [];
            }
        });
    }
}
