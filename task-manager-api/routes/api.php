<?php

use App\Http\Controllers\Api\KeywordController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);

    // Ruta personalizada para toggle
    Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    // Palabras clave
    Route::get('/keywords', [KeywordController::class, 'index']);
    Route::post('/keywords', [KeywordController::class, 'store']);
});