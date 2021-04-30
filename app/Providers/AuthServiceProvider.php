<?php

namespace App\Providers;

use App\Enums\UserRoleType;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMiddlewareGates();
        $this->registerPolicies();
    }

    private function registerMiddlewareGates(): void
    {
        Gate::define('beSuperAdmin', function(User $user) {
            return $user->roles()->whereIn('role_type', UserRoleType::SuperAdministrator)->exists();
        });

        Gate::define('beAdmin', function(User $user) {
            return $user->roles()->whereIn('role_type', [
                UserRoleType::SuperAdministrator,
                UserRoleType::Administrator
            ])->exists();
        });

        Gate::define('beTeacher', function(User $user) {
            return $user->roles()->whereIn('role_type', UserRoleType::SuperAdministrator)->exists();
        });

        Gate::define('beStudent', function(User $user) {
            return $user->roles()->whereIn('role_type', UserRoleType::SuperAdministrator)->exists();
        });
    }
}
