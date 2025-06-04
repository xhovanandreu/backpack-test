<?php

namespace App\Services;

use App\Models\ApplicationUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\throwException;
use Mockery\Exception;

/**
 * @class ApplicationUserService
 */
class ApplicationUserService
{
    /**
     * List destination dates
     *
     * @param string $name
     * @return void
     */
    public function generateApplicationUser(string $name): void
    {

        $user = ApplicationUser::create([
            'name' => $name,
            'app_key' => hash('sha1',$name. Str::random(10)),
            'app_secret' => hash('sha1',$name . Str::random(10)) ,
        ]);

        if(!$user){
            throw new Exception('Could not create application user');
        }

    }
}
