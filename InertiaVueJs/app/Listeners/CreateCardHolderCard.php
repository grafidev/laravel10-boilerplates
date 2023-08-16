<?php

namespace App\Listeners;

class CreateCardHolderCard
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->createNewCard();
    }
}
