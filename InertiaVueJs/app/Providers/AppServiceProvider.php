<?php

namespace App\Providers;

use App\Observers\RoleObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || $this->app->environment('prod')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        Role::observe(RoleObserver::class);

        Cache::macro('forgetIf', function ($key) {
            if (Cache::has($key)) {
                Cache::forget($key);
            }
        });
    }
}
