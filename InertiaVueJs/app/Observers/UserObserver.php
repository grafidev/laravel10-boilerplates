<?php

namespace App\Observers;

use App\Models\Traits\HasPinCode;
use App\Models\User;

class UserObserver
{
    use HasPinCode;

    public function saving(User $user)
    {
        if (! empty($user->firstname) && ! empty($user->lastname)) {
            $user->name = sprintf('%s %s', $user->firstname, strtoupper($user->lastname));
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
