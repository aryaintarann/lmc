<?php

// test_analytics.php
// Usage: php test_analytics.php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Analytics Features Verification ---\n\n";

$service = new \App\Services\GoogleAnalyticsService();

// 1. Test Content Decay Command (and Growth Calculation)
echo "1. Testing Content Decay Command (seo:check-decay)...\n";
try {
    // We run the artisan command which uses the service internally
    $exitCode = \Illuminate\Support\Facades\Artisan::call('seo:check-decay');
    echo \Illuminate\Support\Facades\Artisan::output();

    if ($exitCode === 0) {
        echo "[PASS] Command executed successfully.\n";
    } else {
        echo "[FAIL] Command returned exit code $exitCode.\n";
    }
} catch (\Exception $e) {
    echo "[ERROR] Command failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 2. Test High Bounce Pages
echo "2. Testing High Bounce Pages Service...\n";
try {
    $pages = $service->getHighBouncePages();
    echo "   Result Count: " . count($pages) . "\n";
    echo "   [PASS] Method ran without error.\n";
    if (empty($pages)) {
        echo "   (Note: Currently returns valid empty array, which is expected behavior if mock/no data)\n";
    }
} catch (\Exception $e) {
    echo "   [ERROR] Method failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 3. Test Direct Traffic Change Calculation (Growth)
echo "3. Testing Gravity/Growth Calculation (Direct Service Call)...\n";
try {
    $change = $service->calculateTrafficChange('/random-test-path');
    echo "   Calculated Change: $change%\n";
    echo "   [PASS] Calculation logic ran without error.\n";
} catch (\Exception $e) {
    echo "   [ERROR] Calculation failed: " . $e->getMessage() . "\n";
}
