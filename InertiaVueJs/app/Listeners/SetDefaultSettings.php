<?php

namespace App\Listeners;

use App\Models\Role;

class SetDefaultSettings
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        if ($user->hasRole(Role::ADMIN)) {
            $user->setDefaultSettings();
        }
    }
}
