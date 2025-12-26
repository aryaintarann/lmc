<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TranslationHelper;
use App\Models\Article;
use App\Services\TranslationService;
use Illuminate\Http\Request;

use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Services\ImageService;

class ArticleController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::trending()->latest()->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(StoreArticleRequest $request, TranslationService $translationService, ImageService $imageService)
    {
        $validated = $request->validated();

        // Auto-translate missing language fields
        $validated = TranslationHelper::autoTranslateFields($validated, ['title', 'excerpt', 'content'], $translationService);

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload($request->file('image'), 'articles');
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article, TranslationService $translationService, ImageService $imageService)
    {
        $validated = $request->validated();

        // Auto-translate missing language fields
        $validated = TranslationHelper::autoTranslateFields($validated, ['title', 'excerpt', 'content'], $translationService);

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload($request->file('image'), 'articles', $article->image);
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article, ImageService $imageService)
    {
        if ($article->image) {
            $imageService->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
