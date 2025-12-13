<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(\App\Services\GoogleAnalyticsService $analytics)
    {
        // 1. Content Decay Analysis (Reusing simple logic)
        $articles = \App\Models\Article::whereNotNull('published_at')->get();
        $decayData = [];

        foreach ($articles as $article) {
            $change = $analytics->calculateTrafficChange("/articles/{$article->id}");
            if ($change < -30 || $change > 0) { // Show Movers & Shakers
                $decayData[] = [
                    'title' => $article->title,
                    'change' => $change,
                    'id' => $article->id
                ];
            }
        }

        // 2. High Bounce Pages
        $highBouncePaths = $analytics->getHighBouncePages();
        // Convert paths to articles
        $highBounceArticles = collect($highBouncePaths)->map(function ($path) {
            // Path is /articles/{id}
            preg_match('/\/articles\/(\d+)/', $path, $matches);
            if (isset($matches[1])) {
                return \App\Models\Article::find($matches[1]);
            }
            return null;
        })->filter();


        // 3. Search Terms (Already have widget, but we can show more detail here)
        $searchLogs = \App\Models\SearchLog::selectRaw('query, count(*) as total, sum(case when results_count = 0 then 1 else 0 end) as zero_results')
            ->groupBy('query')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        return view('admin.analytics.index', compact('decayData', 'highBounceArticles', 'searchLogs'));
    }
}
