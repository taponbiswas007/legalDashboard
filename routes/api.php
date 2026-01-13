<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Real-time notification check endpoint (no auth middleware for testing)
Route::get('/check-new-notifications', [NotificationApiController::class, 'checkNewNotifications']);
