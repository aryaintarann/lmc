<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/articles', [LandingController::class, 'articles'])->name('articles.index');
Route::get('/articles/{id}', [LandingController::class, 'show'])->name('articles.show');
Route::post('/preferences', [LandingController::class, 'setPreference'])->name('preferences.set');

// Default Auth Dashboard (optional, redirects here after login by default)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard'); // Redirect to Admin Dashboard
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Config Management
    Route::get('settings/header', [\App\Http\Controllers\Admin\SettingController::class, 'header'])->name('settings.header');
    Route::post('settings/header', [\App\Http\Controllers\Admin\SettingController::class, 'updateHeader'])->name('settings.header.update');

    Route::get('settings/about', [\App\Http\Controllers\Admin\SettingController::class, 'about'])->name('settings.about');
    Route::post('settings/about', [\App\Http\Controllers\Admin\SettingController::class, 'updateAbout'])->name('settings.about.update');

    Route::get('settings/contact', [\App\Http\Controllers\Admin\SettingController::class, 'contact'])->name('settings.contact');
    Route::post('settings/contact', [\App\Http\Controllers\Admin\SettingController::class, 'updateContact'])->name('settings.contact.update');

    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);

    // Owner Only Routes
    Route::middleware('role:owner')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
});

require __DIR__ . '/auth.php';
