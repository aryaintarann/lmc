<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index']);
Route::post('/set-preference', [LandingController::class, 'setPreference'])->name('set-preference');