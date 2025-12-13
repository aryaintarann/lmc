<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckContentDecayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:check-decay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for content decay by comparing month-over-month traffic.';

    /**
     * Execute the console command.
     */
    public function handle(\App\Services\GoogleAnalyticsService $analytics)
    {
        $this->info("🔍 Starting Content Decay Analysis...");

        // 1. Get published articles
        $articles = \App\Models\Article::whereNotNull('published_at')->get();

        if ($articles->isEmpty()) {
            $this->warn("No published articles found.");
            return;
        }

        $this->info("Found {$articles->count()} articles. Checking traffic trends...");

        $bar = $this->output->createProgressBar($articles->count());
        $bar->start();

        $results = [];

        foreach ($articles as $article) {
            $path = "/articles/{$article->id}";

            // Calculate Traffic Change
            $change = $analytics->calculateTrafficChange($path);

            // Advance bar
            $bar->advance();

            // Determine Status
            $status = '✅ Stable';
            if ($change < -30)
                $status = '⚠️ Decay Alert';
            if ($change > 0)
                $status = '📈 Growing';

            $results[] = [
                'Title' => \Illuminate\Support\Str::limit($article->title, 40),
                'Change' => $change . '%',
                'Status' => $status
            ];
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['Article Title', 'Traffic Change (MoM)', 'Status'],
            $results
        );

        $this->info("✅ Analysis Complete!");
    }
}
