<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleAnalyticsService;

class TestContentDecay extends Command
{
    protected $signature = 'test:content-decay';
    protected $description = 'Test the Content Decay logic with date filters';

    public function handle(GoogleAnalyticsService $analytics)
    {
        $this->info('Testing Content Decay Logic (Real Data)...');

        // Note: Without mock data, this will return real GA4 data or 0 if no traffic.

        $articleId = 1; // Dummy ID - Check if this exists or generic path
        $path = "/articles/{$articleId}";

        // Test 1: No Filter (Default)
        $this->comment("1. Testing Default (Last 30 Days)");
        $result = $analytics->calculateTrafficChange($path);
        $this->line("   Result: {$result}%");

        // Test 2: January 2024
        $this->comment("2. Testing Filter: January 2024");
        $result = $analytics->calculateTrafficChange($path, 2024, 1);
        $this->line("   Result: {$result}%");

        // Test 3: February 2024
        $this->comment("3. Testing Filter: February 2024");
        $result = $analytics->calculateTrafficChange($path, 2024, 2);
        $this->line("   Result: {$result}%");

        $this->newLine();
        $this->info('Test Execution Complete.');
    }
}
