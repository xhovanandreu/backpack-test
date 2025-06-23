<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SearchArticlesRequest",
 *     type="object",
 *     title="List Articles Request",
 *     description="Request parameters for listing articles",
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         description="The article text",
 *         example="The Art of Letting Go "
 *     )
 * )
 */
class SearchArticlesRequest extends FormRequest
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
            'text' => ['nullable', 'string', 'max:255'],
        ];
    }
}
