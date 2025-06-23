<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppKeyAuthRequest;
use App\Http\Requests\SearchArticlesRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\AuthKeysResource;
use App\Services\API\ArticleAPIService;
use App\Services\AuthKeysService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticleAPIController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/articles/search",
     *     summary="Get list of articles",
     *     tags={"Articles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *           name="text",
     *           in="query",
     *           required=false,
     *           description="Text to search in articles",
     *           @OA\Schema(type="string", maxLength=255, example="The Art of Letting Go")
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ArticleResource")
     *          )
     *     ),
     *     @OA\Response(
     *           response=400,
     *           description="Bad Request",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      ),
     *       @OA\Response(
     *           response=404,
     *           description="Article not found",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *       ),
     *       @OA\Response(
     *           response=500,
     *           description="Internal Server Error",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *       ),
     *        @OA\Response(
     *           response=401,
     *           description="Unauthorized – Bearer token missing or invalid",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *       ),
     * )
     */
    public function index(SearchArticlesRequest $searchArticlesRequest, ArticleAPIService $articleAPIService): JsonResponse
    {
        try {
            $validatedSearch = $searchArticlesRequest->validated();
            $articles = $articleAPIService->list($validatedSearch['text']);

            return ArticleResource::collection($articles)->response();

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/v1/article/{articleId}",
     *     summary="Retrieve a single article",
     *     tags={"Articles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\PathParameter(
     *          name="articleId",
     *          in="path",
     *          required=true,
     *          description="The ID of the article",
     *          @OA\Schema(type="integer", example=38)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="A single article",
     *          @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *      ),
     *      @OA\Response(
     *            response=400,
     *            description="Bad Request",
     *            @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *       ),
     *       @OA\Response(
     *            response=404,
     *            description="Article not found",
     *            @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *       ),
     *       @OA\Response(
     *            response=500,
     *            description="Internal Server Error",
     *            @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *       ),
     *       @OA\Response(
     *          response=401,
     *          description="Unauthorized – Bearer token missing or invalid",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      ),
     * )
     */
    public function show(string $articleId, ArticleAPIService $articleAPIService): JsonResponse
    {
        try {
            $article = $articleAPIService->show($articleId);
            return ArticleResource::collection($article)->response();

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
