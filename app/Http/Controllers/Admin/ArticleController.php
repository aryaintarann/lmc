<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Helpers\TranslationHelper;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'nullable|max:255',
            'title.id' => 'nullable|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|max:255',
            'excerpt.id' => 'nullable|max:255',
            'content' => 'nullable|array',
            'content.en' => 'nullable',
            'content.id' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Ensure at least one language is provided for title and content
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }
        
        if (empty($request->input('content.en')) && empty($request->input('content.id'))) {
            return back()->withErrors(['content' => 'Please provide content in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $validated = TranslationHelper::autoTranslateFields($validated, ['title', 'excerpt', 'content'], $translationService);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['image'] = $path;
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, string $id, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'nullable|max:255',
            'title.id' => 'nullable|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|max:255',
            'excerpt.id' => 'nullable|max:255',
            'content' => 'nullable|array',
            'content.en' => 'nullable',
            'content.id' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Ensure at least one language is provided for title and content
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }
        
        if (empty($request->input('content.en')) && empty($request->input('content.id'))) {
            return back()->withErrors(['content' => 'Please provide content in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $validated = TranslationHelper::autoTranslateFields($validated, ['title', 'excerpt', 'content'], $translationService);

        $article = Article::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($article->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($article->image);
            }
            $path = $request->file('image')->store('articles', 'public');
            $validated['image'] = $path;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(string $id)
    {
        $article = \App\Models\Article::findOrFail($id);

        if ($article->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
