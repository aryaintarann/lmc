<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = \App\Models\Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|max:255',
            'title.id' => 'nullable|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|max:255',
            'excerpt.id' => 'nullable|max:255',
            'content' => 'required|array',
            'content.en' => 'required',
            'content.id' => 'nullable',
            'image' => 'nullable|image|max:2048', // Validate as image
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['image'] = $path;
        }

        \App\Models\Article::create($validated);

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

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|max:255',
            'title.id' => 'nullable|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|max:255',
            'excerpt.id' => 'nullable|max:255',
            'content' => 'required|array',
            'content.en' => 'required',
            'content.id' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $article = \App\Models\Article::findOrFail($id);

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
