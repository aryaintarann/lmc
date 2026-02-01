<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->unique('slug');
        });

        // Generate slugs for existing articles
        $articles = \App\Models\Article::all();
        foreach ($articles as $article) {
            $baseSlug = \Illuminate\Support\Str::slug($article->getTranslation('title', 'en'));
            $slug = $baseSlug;
            $counter = 1;

            // Ensure uniqueness
            while (\App\Models\Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $article->slug = $slug;
            $article->save();
        }

        // Make slug non-nullable after populating
        Schema::table('articles', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
