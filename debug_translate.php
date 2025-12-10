<?php
use Stichoza\GoogleTranslate\GoogleTranslate;

try {
    echo "Testing Google Translate...\n";
    $tr = new GoogleTranslate('id');
    echo "Translation: " . $tr->translate('Hello World') . "\n";

    echo "Testing Model AutoTranslate...\n";
    $article = new \App\Models\Article();
    $article->title = 'Test Title';
    $article->content = 'Test Content';
    $article->published_at = now();
    $article->save();

    print_r($article->getTranslations('title'));
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
