<?php

namespace App\Listeners;

use App\Notifications\AccountCreated;

class UserAccountCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->notify(new AccountCreated());
    }
}
