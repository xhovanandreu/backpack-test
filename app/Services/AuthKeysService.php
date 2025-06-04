<?php
namespace App\Services;

use App\Models\ApplicationUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

/**
 * @class AuthKeysService
 */
class AuthKeysService
{
    /**
     * Verify keys are correct
     *
     * @param array $credentials
     * @return ApplicationUser
     */

    public function login(array $credentials): ApplicationUser
    {
        $user = ApplicationUser::verifyKeys($credentials['app_key'], $credentials['app_secret'])->first();

        if (!$user) {
            throw new Exception('Keys incorrect');
        }

        $user->token = $user->createToken('api-access')->plainTextToken;

        return $user;
    }

}
