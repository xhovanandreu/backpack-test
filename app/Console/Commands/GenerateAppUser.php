<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\ApplicationUserService as AppUserService;
class GenerateAppUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'app:generate-app-user {name : The name of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new app user using the provided name.';

    /**
     * Execute the console command.
     *
     * @param AppUserService $appUserService
     *
     * @retuen void
     */
    public function handle(AppUserService $appUserService):void
    {
        try {

            if (!filter_var($this->argument('name'), FILTER_VALIDATE_REGEXP, [
                "options" => ["regexp" => "/^[a-zA-Z0-9-' ]+$/"]
            ])) {
                $this->error('Invalid name!');
            }

            $name = $this->argument('name');

            $appUserService->generateApplicationUser($name);

        } catch (\Exception $e) {

            $this->error($e->getMessage());
        }

    }
}
