<?php

use App\Http\Controllers\Ads\AdController;
use App\Http\Controllers\AdViewController;
use App\Http\Controllers\Guests\GuestAdController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Guest Show Single Ad Route (route-model binding)
Route::get('/guests/ads/{ad}', [GuestAdController::class, 'show'])->name('guests.ads.show');

// Ad Creation Route
Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');

Route::middleware('auth')->group(function () {
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::post('/ads/{ad}/toggle-availability', [AdController::class, 'toggleAvailability'])->name('ads.toggle-availability');
    Route::post('/ads/{ad}/toggle-active', [AdController::class, 'toggleActive'])->name('ads.toggle-active');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
});

Route::get('/', function () {
    $popularAds = \App\Models\Ad::query()
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
});

require __DIR__.'/auth.php';

// Tracking endpoint for ad views
Route::post('/ads/{ad}/view', [AdViewController::class, 'store'])->name('ads.view');
