<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AppKeyAuthRequest",
 *     type="object",
 *     title="Login with public key and secret key Request",
 *     description="Request parameters to identify user has access",
 *     @OA\Property(
 *         property="app_key",
 *         type="string",
 *         description="Generated Public Key",
 *         example="3ebd11afbf17bf7780a76a0288262cc05dd8848d"
 *     ),
 *     @OA\Property(
 *         property="app_secret",
 *         type="string",
 *         description="Generated Secret Key",
 *         example="445d314af62141f846b2fa547521e9ff70c36b11"
 *     )
 * )
 */
class AppKeyAuthRequest extends FormRequest
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
            'app_key' => 'required|string',
            'app_secret' => 'required|string',
        ];
    }
}
