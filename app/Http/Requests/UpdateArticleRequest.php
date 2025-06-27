<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateArticleRequest",
 *     type="object",
 *     title="Update Article Data Request",
 *     description="Update articles data",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The article title",
 *         example="My New Title"
 *     ),
 *     @OA\Property(
 *         property="subtitle",
 *         type="string",
 *         description="The article subtitle",
 *         example="My Subtitle"
 *     ),
 *     @OA\Property(
 *         property="body",
 *         type="string",
 *         description="The article body",
 *         example="Some body text"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         example="my-new-title"
 *     )
 * )
 */
class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string'],
            'subtitle' => ['required','string'],
            'body' => ['required','string'],
            'slug' => [
                'required',
                'string',
                Rule::unique('articles')->ignore($this->article->id),
            ],
        ];
    }
}
