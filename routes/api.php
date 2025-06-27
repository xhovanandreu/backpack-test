<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleAPIController;
use App\Http\Controllers\API\LoginAPIController;
use App\Models\Article;

Route::post('/login', [LoginAPIController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('articles', ArticleAPIController::class);
});
