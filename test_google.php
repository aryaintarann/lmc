<?php
require 'vendor/autoload.php';
use Stichoza\GoogleTranslate\GoogleTranslate;

try {
    echo "Testing simple translation...\n";
    $text = GoogleTranslate::trans('Hello World', 'id');
    echo "Result: " . $text . "\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
