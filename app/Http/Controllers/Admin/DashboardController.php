<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => \App\Models\Service::count(),
            'doctors' => \App\Models\Doctor::count(),
            'articles' => \App\Models\Article::count(),
            'users' => \App\Models\User::count(),
        ];
        $recentArticles = \App\Models\Article::latest()->take(5)->get();

        // Zero Result Analysis: Top 5 Missing Keywords
        $missingKeywords = \App\Models\SearchLog::where('results_count', 0)
            ->select('query', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('query')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'missingKeywords'));
    }
}
