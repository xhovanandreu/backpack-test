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
     * @return Article
     */
    public function show(string $articleId) : Article
    {
        return Article::find($articleId);
    }


    /**
     * Single article datils
     *
     * @param string $articleId
     *
     * @return Article
     */
    public function store(array $request) : Article
    {
        return Article::create($request);
    }


}
