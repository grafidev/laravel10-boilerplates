<?php

namespace App\Listeners;

use Illuminate\Support\Str;

class SetNewPasswordLinkData
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->forceFill([
            'new_password_token' => Str::uuid(),
            'new_password_token_expiration_date' => now()->addMinutes(config('new_password.link_duration')),
        ])->save();
    }
}
