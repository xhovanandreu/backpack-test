<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AuthKeysResource",
 *     type="object",
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="token", type="string", example="19|z3fbgx1XiDS8CSjGFUJ2edj5Ef1rcnQDGe8P99yt0b21740b"),
 *     @OA\Property(property="name", type="string", example="xhovana"),
 * )
 */
class AuthKeysResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => true,
            'token' => $this->token,
            'name' => $this->name,
        ];
    }
}
