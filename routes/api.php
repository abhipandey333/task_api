<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Used passport middleware for security of routes.
Route::middleware('auth:api')->group(function () {

    Route::controller(TaskController::class)->group(function () {
        Route::post('/create-task', 'store');
        Route::post('/tasks-with-notes', [TaskController::class, 'getTasks']);
    });
});
