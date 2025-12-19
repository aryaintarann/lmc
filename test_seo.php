<?php

// test_seo.php
// Usage: php test_seo.php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

// Force HTTPS for checking if in production
if (app()->environment('production')) {
    URL::forceScheme('https');
}

echo "--- SEO Verification Diagnostics ---\n";

$baseUrl = config('app.url');
echo "Target URL: $baseUrl\n\n";

// 1. Check Sitemap
echo "1. Testing Sitemap Generation...\n";
try {
    // Run the command manually
    echo "   Running 'sitemap:generate'...\n";
    $exitCode = \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
    echo "   Command Exit Code: $exitCode\n";

    $sitemapPath = public_path('sitemap.xml');
    if (file_exists($sitemapPath)) {
        echo "   [PASS] sitemap.xml created at public/sitemap.xml\n";
        echo "   Size: " . filesize($sitemapPath) . " bytes\n";
    } else {
        echo "   [FAIL] sitemap.xml NOT found in public/ folder.\n";
    }
} catch (\Exception $e) {
    echo "   [ERROR] Sitemap generation failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 2. Check Homepage Meta & Schema
echo "2. Testing Homepage SEO (Local Request)...\n";
try {
    // RESOLVE DEPENDENCIES MANUALLY (Simulating Controller)
    $schemaService = app(\App\Services\SchemaService::class);
    $schema = $schemaService->getOrganizationSchema()->toScript() .
        $schemaService->getMedicalClinicSchema()->toScript();

    // Fetch Data (Simulating LandingController)
    $header = \App\Models\Header::first();
    $contact = \App\Models\Contact::first();
    $about = \App\Models\About::first();
    $services = \App\Models\Service::all();
    $doctors = \App\Models\Doctor::all();
    $landingArticles = \App\Models\Article::whereNotNull('published_at')->latest('published_at')->take(3)->get();
    $totalArticles = 0; // Simplified for test

    // Render View with Data
    $html = view('landing', compact('header', 'contact', 'about', 'services', 'doctors', 'landingArticles', 'totalArticles', 'schema'))->render();

    // Check Title
    if (preg_match('/<title>(.*?)<\/title>/', $html, $matches)) {
        echo "   [PASS] Title Tag Found: " . substr($matches[1], 0, 50) . "...\n";
    } else {
        echo "   [FAIL] No <title> tag found.\n";
    }

    // Check Meta Description
    if (strpos($html, 'name="description"') !== false) {
        echo "   [PASS] Meta Description Found.\n";
    } else {
        echo "   [FAIL] Meta Description missing.\n";
    }

    // Check Schema
    if (strpos($html, 'application/ld+json') !== false) {
        echo "   [PASS] Schema.org (LD+JSON) Script Found.\n";

        // Extract JSON to validate parsing
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);
        if (!empty($matches[1])) {
            $json = json_decode($matches[1], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                echo "   [PASS] Schema JSON is valid syntax.\n";
                // echo "   Type: " . ($json['@type'] ?? 'Unknown') . "\n";
            } else {
                echo "   [FAIL] Schema JSON syntax error.\n";
                echo "   Error: " . json_last_error_msg() . "\n";
            }
        }
    } else {
        echo "   [FAIL] Schema.org (LD+JSON) missing.\n";
    }

} catch (\Exception $e) {
    echo "   [ERROR] Could not render homepage: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

echo "\n";

// 3. Check Article Meta (Mock Article if possible)
echo "3. Checks passed? (Summary)\n";
echo "If all above passed, your SEO foundation is solid.\n";
echo "Note: Robots.txt should also be checked manually at /robots.txt\n";
