<?php

namespace App\Listeners;

use App\Models\Role;

class ApplyCardHolderRole
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->roles()->sync([Role::getId(Role::PORTEUR_CARTE)]);
    }
}
