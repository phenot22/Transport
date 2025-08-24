<?php

namespace App\Listeners;

use App\Models\LoginHistory;
use Illuminate\Auth\Events\Login;

class LogLoginHistory
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Log the login history into the database
        LoginHistory::create([
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'login_time' => now(),
        ]);
    }
}

