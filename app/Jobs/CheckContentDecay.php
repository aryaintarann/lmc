<?php

namespace App\Jobs;

use App\Services\GoogleAnalyticsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckContentDecay implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GoogleAnalyticsService $analytics): void
    {
        // 1. Get all published articles
        $articles = \App\Models\Article::whereNotNull('published_at')->get();

        foreach ($articles as $article) {
            // 2. Construct Path (assuming standard route)
            $path = "/articles/{$article->id}";

            // 3. Check Traffic Change
            $change = $analytics->calculateTrafficChange($path);

            // 4. Alert if drop is significant (> 30% drop)
            if ($change < -30) {
                // Log the alert (In a real app, this would send an email/Slack)
                \Illuminate\Support\Facades\Log::warning("⚠️ CONTENT DECAY ALERT: Article '{$article->title}' dropped by {$change}% in traffic.");

                // Optional: Mark in DB if we added a column
                // $article->update(['trend_data->decay_alert' => true]);
            }
        }

        \Illuminate\Support\Facades\Log::info("Decay Check Complete. Scanned {$articles->count()} articles.");
    }
}
