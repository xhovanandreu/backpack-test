<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * Return data using the formated array from ArticleResource
     *
     * @return AnonymousResourceCollection
     */

    public function getAllArticles(): AnonymousResourceCollection
    {
        return ArticleResource::collection(Article::all());
    }
}
