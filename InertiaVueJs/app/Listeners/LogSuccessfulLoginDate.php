<?php

namespace App\Listeners;

class LogSuccessfulLoginDate
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->forceFill(['last_login_date' => now()])->save();
    }
}
