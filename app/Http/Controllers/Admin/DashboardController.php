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
            'settings' => \App\Models\Setting::count(),
        ];
        $recentArticles = \App\Models\Article::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }
}
