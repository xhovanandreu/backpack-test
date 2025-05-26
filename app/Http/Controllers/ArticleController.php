<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AppKeyAuthRequest;
use App\Models\Article;
use App\Models\ApplicationUser;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\AuthKeysResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

use App\Services\AuthKeysService;

class ArticleController extends Controller
{
    /**
     * Return data using the formated array from ArticleResource
     *
     * @return JsonResponse
     */
    public function getAllArticles(): JsonResponse
    {
        try {
            return ArticleResource::collection(Article::all())->response()->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Generate Sanctum token using app_key and app_secret
     * @param AppKeyAuthRequest $request
     * @param AuthKeysService $authService
     * @return JsonResponse
     */
    public function login(AppKeyAuthRequest $request, AuthKeysService $authService): JsonResponse
    {
        try {
            $user = $authService->login($request->validated());
            return (new AuthKeysResource($user))->response()->setStatusCode(200);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }

}
