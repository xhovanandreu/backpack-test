<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ApplicationUser;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\throwException;

class ArticleController extends Controller
{
    /**
     * Return data using the formated array from ArticleResource
     *
     * @return \Illuminate\Http\AnonymousResourceCollection
     */

    public function getAllArticles(Request $request): AnonymousResourceCollection
    {
        return ArticleResource::collection(Article::all());
    }

    /**
     * Generate Sanctum token using app_key and app_secret
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'app_secret' => 'required|string',
            'app_key' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        try {

            $applicationUser = ApplicationUser::where('app_key', $request->app_key)
                ->where('app_secret', $request->app_secret)
                ->first();

            if($applicationUser){
                $token = $applicationUser->createToken('api-access')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'token' => $token,
                    'name' => $applicationUser->name
                ], 200);

            }else{

                return response()->json([ 'status' => false,'error' => 'Keys incorrect'], 401);
            }
        } catch (\Throwable $e) {
                return response()->json(['status' => false,'error' => 'Something went wrong'], 401);
        }

    }
}
