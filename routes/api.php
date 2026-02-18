<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TodoController;

use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [LoginController::class, 'logout']);

    Route::get('/todos/stats', [TodoController::class, 'stats']);
    Route::patch('/todos/{id}/toggle', [TodoController::class, 'toggle']);
    Route::post('/todos/{id}/restore', [TodoController::class, 'restore']);
    Route::delete('/todos/{id}/force', [TodoController::class, 'forceDestroy']);


    Route::apiResource('todos', TodoController::class);
});
