<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Doctor;
use App\Models\Gallery;
use App\Models\Header;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(\App\Services\SchemaService $schemaService)
    {
        $header = Header::first();
        $contact = Contact::first();
        $about = About::first();
        $services = Service::all();
        $doctors = Doctor::all();
        $galleries = Gallery::active()->ordered()->get();
        $articles = Article::whereNotNull('published_at')
            ->orderBy('trend_score', 'desc')
            ->latest('published_at')
            ->get();
        $landingArticles = $articles->take(3);
        $totalArticles = $articles->count();

        $schema = $schemaService->getOrganizationSchema()->toScript() .
            $schemaService->getMedicalClinicSchema()->toScript();

        return view('landing', compact('header', 'contact', 'about', 'services', 'doctors', 'galleries', 'landingArticles', 'totalArticles', 'schema'));
    }

    public function articles(Request $request)
    {
        $query = Article::whereNotNull('published_at');

        // Search Filter
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $query->orderBy('trend_score', 'desc')
            ->latest('published_at');

        $articles = $query->get();

        // 🔍 Zero Result Analysis Logging
        if ($search) {
            \App\Models\SearchLog::create([
                'query' => $search,
                'results_count' => $articles->count(),
                'ip_address' => $request->ip(),
            ]);
        }

        return view('articles', compact('articles'));
    }

    public function show($id, \App\Services\GoogleAnalyticsService $analytics, \App\Services\SchemaService $schemaService)
    {
        $article = Article::whereNotNull('published_at')->findOrFail($id);

        $schema = $schemaService->getArticleSchema($article)->toScript();

        // High Exit Rate Optimization
        $highBouncePages = $analytics->getHighBouncePages();
        $isHighBounce = in_array("/articles/{$id}", $highBouncePages);

        // Always fetch recommended articles (excluding current)
        $relatedArticles = Article::where('id', '!=', $id)
            ->whereNotNull('published_at')
            ->orderBy('trend_score', 'desc')
            ->take(3)
            ->get();

        return view('article_show', compact('article', 'isHighBounce', 'relatedArticles', 'schema'));
    }

    public function setPreference(Request $request)
    {
        $request->validate([
            'preference' => 'required|string|in:services,doctors,contact,all',
        ]);

        // Store preference in session
        session(['lmc_preference' => $request->preference]);

        return response()->json(['success' => true, 'message' => 'Preference saved']);
    }
}
