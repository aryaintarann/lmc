<?php
$article = new \App\Models\Article();
$article->published_at = '2025-01-01';
try {
    echo "Type of published_at: " . gettype($article->published_at) . "\n";
    if (is_object($article->published_at)) {
        echo "Class of published_at: " . get_class($article->published_at) . "\n";
    }
    echo "Date attribute: " . $article->date . "\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
