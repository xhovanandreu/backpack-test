<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::post('/login', [ArticleController::class, 'login']);

Route::get('/get-all-articles', [ArticleController::class, 'getAllArticles'])->middleware('auth:sanctum');
