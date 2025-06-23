<?php

namespace App\Services\API;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleAPIService
{
    /**
     * List articles with optional search
     *
     * @param array|null $searchText
     *
     * @return Collection
     */
    public function list(string|null $searchText) : Collection
    {
        if ($searchText == null) {
            return Article::all();
        }

        return Article::search($searchText)->get();
    }

    /**
     * Single article datils
     *
     * @param string $articleId
     *
     * @return Collection
     */
    public function show(string $articleId) : Collection
    {
        return Article::where('id',$articleId)->get();
    }

}
