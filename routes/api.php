<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventTypeController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ViewerMiddleware;

// Routes publiques
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

      // Dashboard — lecture seule OK
    Route::get('/dashboard',   [DashboardController::class, 'index']);
    Route::get('/event-types', [EventTypeController::class, 'index']);
    Route::get('/materials',   [MaterialController::class, 'index']);

    // Événements — lecture OK pour tous
    Route::get('/events',      [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // Types et matériels (lecture seule)
    Route::get('/event-types', [EventTypeController::class, 'index']);
    Route::get('/materials',   [MaterialController::class, 'index']);

     // Événements — écriture interdite aux viewers
    Route::middleware(ViewerMiddleware::class)->group(function () {
        Route::post('/events',            [EventController::class, 'store']);
        Route::put('/events/{event}',     [EventController::class, 'update']);
        Route::delete('/events/{event}',  [EventController::class, 'destroy']);
    });

    // Utilisateurs — admin seulement
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/users',           [UserController::class, 'index']);
        Route::post('/users',          [UserController::class, 'store']);
        Route::put('/users/{user}',    [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

});

