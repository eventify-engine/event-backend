<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Conference;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'index']);

    Route::get('conferences/host-prefix', [ConferenceController::class, 'hostPrefix']);
    Route::apiResource('conferences', ConferenceController::class);

    Route::apiResource('conferences.events', EventController::class);
});

Route::prefix('conference')->group(function () {
    Route::get('/', Conference\ShowController::class);
});
