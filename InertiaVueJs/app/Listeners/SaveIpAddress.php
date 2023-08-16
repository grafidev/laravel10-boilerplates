<?php

namespace App\Listeners;

use Jenssegers\Agent\Agent;

class SaveIpAddress
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $agent = new Agent();

        $ipAddress = $agent->isMobile() || $agent->isTablet()
            ? request()->header('HTTP_X_FORWARDED_FOR') ?? request()->header('HTTP_X_REMOTE_ADDR')
            : request()->ip();

        $event->user->forceFill(['ip_address' => $ipAddress])->save();
    }
}
