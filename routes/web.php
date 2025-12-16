<?php

use App\Http\Controllers\Ads\AdController;
use App\Http\Controllers\AdViewController;
use App\Http\Controllers\Guests\GuestAdController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Guest Show Single Ad Route (route-model binding)
Route::get('/guests/ads/{ad}', [GuestAdController::class, 'show'])->name('guests.ads.show');

//About
Route::get('/about', function () {return view('/guests.div.about');})->name('guests.div.about');

//Price Info
Route::get('/price', function () {return view('/guests.div.price');})->name('price');

//GDPR
Route::get('/gdpr', function () {return view('/guests.div.gdpr');})->name('gdpr');

// Ad Creation Route
Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');

Route::middleware('auth')->group(function () {
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::post('/ads/{ad}/toggle-availability', [AdController::class, 'toggleAvailability'])->name('ads.toggle-availability');
    Route::post('/ads/{ad}/toggle-active', [AdController::class, 'toggleActive'])->name('ads.toggle-active');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
});

Route::get('/', function () {
    $popularAds = \App\Models\Ad::query()
        ->with('primaryImage')
        ->withRecentViewsCount(7)
        ->orderByDesc('recent_views_count')
        ->limit(3)
        ->get();

    return view('home', compact('popularAds'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.update-settings');
});

require __DIR__.'/auth.php';

// Tracking endpoint for ad views
Route::post('/ads/{ad}/view', [AdViewController::class, 'store'])->name('ads.view');
