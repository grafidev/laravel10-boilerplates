<?php

namespace App\Listeners;

use App\Models\Role;

class StationManagerListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        $user->roles()->sync(Role::getId(Role::GERANT_STATION));
        $user->companies()->sync(current_company_id());
    }
}
