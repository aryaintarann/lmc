<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index']);
Route::get('/articles', [LandingController::class, 'articles'])->name('articles.index');
Route::get('/articles/{id}', [LandingController::class, 'show'])->name('articles.show');
Route::post('/set-preference', [LandingController::class, 'setPreference'])->name('set-preference');