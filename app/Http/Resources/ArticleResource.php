<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Article;

/**
 * @OA\Schema(
 *     schema="ArticleResource",
 *     type="object",
 *     @OA\Property(property="title", type="string", example="The Art of Letting Go: Why Detachment Brings Peace"),
 *     @OA\Property(property="subtitle", type="string", example="Understanding the freedom in releasing control and expectations"),
 *     @OA\Property(property="body", type="string", example="In a world that constantly encourages us to hustle, chase, and control outcomes, the idea of letting go can feel like giving up. But true peace and growth often begin when we detach from what we can't control. By surrendering the need for a fixed result, you free yourself from unnecessary anxiety. You allow life to unfold naturally, and often, in better ways than you imagined. Practicing detachment is not weakness; it's strength rooted in trust and emotional maturity."),
 *     @OA\Property(property="slug", type="string", example="the-art-of-letting-go"),
 * )
 *
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'body' => $this->body,
            'slug' => $this->slug
        ];
    }
}
