<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/notifications', [PushNotificationController::class, 'sendNotification']);

Route::post('/v1/news', [PushNotificationController::class, 'sendNews']);

Route::post('/v1/banners', [BannerController::class, 'store']);

Route::get('/v1/banners/{group}', [BannerController::class, 'Groups']);
