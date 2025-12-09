<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    private function getArticles()
    {
        return [
            [
                'id' => 1,
                'title' => '5 Tips for a Healthy Heart',
                'date' => 'Aug 12, 2024',
                'excerpt' => 'Discover simple lifestyle changes that can significantly improve your heart health and longevity.',
                'image' => 'https://placehold.co/600x400?text=Heart+Health'
            ],
            [
                'id' => 2,
                'title' => 'Boosting Your Immune System',
                'date' => 'Jul 28, 2024',
                'excerpt' => 'Learn how your body fights off infections and what you can do to support your natural defenses.',
                'image' => 'https://placehold.co/600x400?text=Immune+System'
            ],
            [
                'id' => 3,
                'title' => 'Importance of Regular Checkups',
                'date' => 'Jun 15, 2024',
                'excerpt' => 'Why you shouldn\'t skip your annual physical and what early detection means for your health.',
                'image' => 'https://placehold.co/600x400?text=Regular+Checkups'
            ],
            [
                'id' => 4,
                'title' => 'Understanding Mental Health',
                'date' => 'May 10, 2024',
                'excerpt' => 'Breaking the stigma around mental health and knowing when to seek professional help.',
                'image' => 'https://placehold.co/600x400?text=Mental+Health'
            ],
            [
                'id' => 5,
                'title' => 'Nutrition 101: A Balanced Diet',
                'date' => 'Apr 22, 2024',
                'excerpt' => 'The fundamentals of good nutrition and how to build a diet that fuels your body effectively.',
                'image' => 'https://placehold.co/600x400?text=Nutrition'
            ],
        ];
    }

    public function index()
    {
        $articles = $this->getArticles();
        $landingArticles = array_slice($articles, 0, 3);
        $totalArticles = count($articles);

        return view('landing', compact('landingArticles', 'totalArticles'));
    }

    public function articles()
    {
        $articles = $this->getArticles();
        return view('articles', compact('articles'));
    }

    public function show($id)
    {
        $articles = $this->getArticles();
        $article = collect($articles)->firstWhere('id', $id);

        if (!$article) {
            abort(404);
        }

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
