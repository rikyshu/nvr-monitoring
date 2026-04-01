<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NvrDashboardController;
use App\Http\Controllers\Api\NvrWebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Secure Webhook for Hikvision NVR (auth via token in header/query via controller)
Route::post('/webhook/hikvision', [NvrWebhookController::class, 'receiveEvent']);

// Dashboard APIs (protected by Sanctum)
Route::middleware('auth:sanctum')->prefix('nvr')->group(function () {
    Route::get('/summary', [NvrDashboardController::class, 'getSummary']);
    Route::get('/chart-data', [NvrDashboardController::class, 'getChartData']);
    Route::get('/recent-logs', [NvrDashboardController::class, 'getRecentLogs']);
    Route::get('/cameras', [NvrDashboardController::class, 'getCameras']);
});
