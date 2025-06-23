<?php

namespace App\Http\Controllers;
/**
 * @OA\Info(title="Public API", version="0.1")
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 *  ),
 *
 * @OA\Schema(
 *       schema="ErrorResponse",
 *       type="object",
 *       @OA\Property(property="success", type="boolean", example=false),
 *       @OA\Property(property="message", type="string", example="An error occurred.")
 * )
 */
abstract class Controller
{
    //
}
