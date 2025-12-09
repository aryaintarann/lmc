<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::pluck('value', 'key');
        $services = \App\Models\Service::all();
        $doctors = \App\Models\Doctor::all();
        $articles = \App\Models\Article::whereNotNull('published_at')->latest('published_at')->get();
        $landingArticles = $articles->take(3);
        $totalArticles = $articles->count();

        return view('landing', compact('settings', 'services', 'doctors', 'landingArticles', 'totalArticles'));
    }

    public function articles()
    {
        $articles = \App\Models\Article::whereNotNull('published_at')->latest('published_at')->get();
        return view('articles', compact('articles'));
    }

    public function show($id)
    {
        $article = \App\Models\Article::whereNotNull('published_at')->findOrFail($id);
        return view('article_show', compact('article'));
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
