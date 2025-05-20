<?php

namespace App\Listeners;

//use IlluminateAuthEventsLogin;
use Illuminate\Auth\Events\Login as IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IlluminateAuthEventsLogin $event): void
    {
        // git change purpose;
        $event->user->increment("login_count");
    }
}
