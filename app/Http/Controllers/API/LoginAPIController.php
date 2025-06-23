<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppKeyAuthRequest;
use App\Http\Resources\AuthKeysResource;
use App\Services\AuthKeysService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoginAPIController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login useig keys",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/AppKeyAuthRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Authed user",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AuthKeysResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *             description="Bad Request",
     *             @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *           response=404,
     *           description="Article not found",
     *           @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */

    public function login(AppKeyAuthRequest $request, AuthKeysService $authService): JsonResponse
    {
        try {
            $user = $authService->login($request->validated());
            return (new AuthKeysResource($user))->response()->setStatusCode(200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_NOT_FOUND);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
