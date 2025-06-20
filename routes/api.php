<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleAPIController;
use App\Http\Controllers\API\LoginAPIController;

Route::post('/login', [LoginAPIController::class, 'login']);

Route::prefix('v1')->group(function () {
        Route::get('/articles/search', [ArticleAPIController::class, 'index']);
        Route::get('/article/{articleId}', [ArticleAPIController::class, 'show']);
});

