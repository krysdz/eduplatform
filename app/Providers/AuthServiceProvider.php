<?php

namespace App\Providers;

use App\Enums\UserRoleType;
use App\Models\File;
use App\Models\Group;
use App\Models\Message;
use App\Models\Section;
use App\Models\Thread;
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
        Gate::define('super_administrator', function (User $user) {
            return $user->roles()->where(['type' => UserRoleType::SuperAdministrator])->exists();
        });

        Gate::define('administrator', function (User $user) {
            return $user->roles()->whereIn('type', [
                UserRoleType::SuperAdministrator,
                UserRoleType::Administrator
            ])->exists();
        });

        Gate::define('teacher', function (User $user) {
            return $user->roles()->where(['type' => UserRoleType::Teacher])->exists();
        });

        Gate::define('student', function (User $user) {
            return $user->roles()->where(['type' => UserRoleType::Student])->exists();
        });

        Gate::define('access_file', function (User $user, File $file) {
            switch ($file->fileable_type) {
                case Section::class:
                    /** @var Group $group */
                    $group = $file->fileable->group;
                    $isUnpublished = is_null($file->fileable->published_at);

                    if ($isUnpublished) {
                        $isAuthorized = $group->teachersRelation->contains(auth()->user());
                    } else {
                        $isAuthorized = $group->groupMembers->contains(auth()->user());
                    }

                    if (!$isAuthorized) {
                        return false;
                    }

                    break;
                case Message::class:
                    /** @var Thread $thread */
                    $thread = $file->fileable->thread;

                    if (!$thread->threadUsers->contains(auth()->user())) {
                        return false;
                    }

                    break;
                default:
                    abort(404);
            }

            return true;
        });

        Gate::define('access_thread', function (User $user, Thread $thread) {
            if (!$thread->threadUsers->contains(auth()->user())) {
                return false;
            }

            return true;
        });
    }
}
