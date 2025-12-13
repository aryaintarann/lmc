<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Services\TrendAnalysisService;

class AnalyzeTrends extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trends:analyze';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze Google Trends and GA4 data to update article scores';

    /**
     * Execute the console command.
     */
    public function handle(TrendAnalysisService $service)
    {
        $this->info("Starting Trend Analysis...");

        try {
            $service->analyzeAndUpdateScores();
            $this->info("Analysis completed successfully. Article scores updated.");
        } catch (\Exception $e) {
            $this->error("Analysis failed: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
