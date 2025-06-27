<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppKeyAuthRequest;
use App\Http\Requests\SearchArticlesRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\AuthKeysResource;
use App\Models\Article;
use App\Services\API\ArticleAPIService;
use App\Services\AuthKeysService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleAPIController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/articles",
     *     summary="Get list of articles",
     *     tags={"Articles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *           name="search",
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
            $articles = $articleAPIService->list($validatedSearch['search']);

            return ArticleResource::collection($articles)->response();

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/v1/articles/{slug}",
     *     summary="Retrieve a single article",
     *     tags={"Articles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\PathParameter(
     *          name="slug",
     *          in="path",
     *          required=true,
     *          description="The slug of the article",
     *          @OA\Schema(type="string", example="the-art-of-letting-go")
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
    public function show(Article $article): JsonResponse
    {
        try {
            return (new ArticleResource($article))->response();

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/v1/articles",
     *     summary="Add a new article",
     *     tags={"Articles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreArticleRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Article saved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AuthKeysResource")
     *         )
     *     ),
     *     @OA\Response(
     *           response=422,
     *           description="Article not saved",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function store(StoreArticleRequest $storeArticleRequest, ArticleAPIService $articleAPIService): JsonResponse
    {
        try {
            $validatedRequest = $storeArticleRequest->validated();

            $article = $articleAPIService->store($validatedRequest);

            return response()->json(['success' => true, 'message' => 'Article saved successfully', 'data' => (new ArticleResource($article))]);

        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }



    /**
     * @OA\Put(
     *     path="/api/v1/articles/{slug}",
     *     summary="Update an existing article",
     *     description="Updates the specified article using the given data",
     *     operationId="updateArticle",
     *     tags={"Articles"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *          name="slug",
     *          in="path",
     *          description="Slug of the article to update",
     *          required=true,
     *          @OA\Schema(type="string", example="my-new-title")
     *      ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/UpdateArticleRequest")
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Article updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Article updated successfully")
     *          )
     *      ),
     *
     *     @OA\Response(
     *           response=422,
     *           description="Article not saved",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function update(UpdateArticleRequest $updateArticleRequest, Article $article): JsonResponse
    {
        try {
            $article->update($updateArticleRequest->validated());

            return response()->json(['success' => true, 'message' => 'Article updated successfully', 'data' => (new ArticleResource($article))]);

        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
