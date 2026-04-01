<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'admin'])->prefix('cms')->name('cms.')->group(function () {
    Route::resource('users', \App\Http\Controllers\CmsUserController::class);
});

require __DIR__.'/auth.php';
