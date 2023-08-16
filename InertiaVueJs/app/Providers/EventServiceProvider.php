<?php

namespace App\Providers;

use App\Events\UserAccountCreated;
use App\Listeners\LogSuccessfulLoginDate;
use App\Listeners\SaveIpAddress;
use App\Listeners\SetNewPasswordLinkData;
use App\Listeners\UserAccountCreatedNotification;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserAccountCreated::class => [
            SetNewPasswordLinkData::class,
            UserAccountCreatedNotification::class,
        ],
        Login::class => [
            SaveIpAddress::class,
            LogSuccessfulLoginDate::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}