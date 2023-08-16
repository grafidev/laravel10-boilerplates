<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Role;
use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('super_admin', fn (User $user) => $user->roles()->count() == 1 && $user->hasRole(Role::SUPER_ADMIN));
        Gate::define('admin', fn (User $user) => $user->roles()->count() == 1 && $user->hasRole(Role::ADMIN));
        Gate::define('make_transaction', function (User $user) {
            if (! $user->active || $user->wallet->is_blocked) {
                return false;
            }

            if (! $user->hasValidCountry()) {
                return false;
            }

            return true;
        });

        Gate::define('validation_finance', function (User $user) {
            if ($user->can('admin') && $user->profile_type == Role::DIRECTEUR_FINANCIER) {
                return true;
            }

            return null;
        });

        Gate::define('validation_commerciale', function (User $user) {
            if ($user->hasRole(Role::ADMIN) && $user->profile_type == Role::DIRECTEUR_COMMERCIAL) {
                return true;
            }

            return null;
        });

        Gate::define('handle_recharge_validation', function (User $user) {
            if ($user->can('validation_finance') || $user->can('validation_commerciale')) {
                return true;
            }

            return null;
        });

        Gate::define('cancel_transaction', function (User $user) {
            return $user->roles()->count() === 1 && $user->hasRole([
                Role::ADMIN,
                ...Role::STATION_ROLES,
            ]);
        });
    }
}
