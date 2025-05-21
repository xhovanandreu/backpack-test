<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/get-all-articles', [ArticleController::class, 'getAllArticles']);
