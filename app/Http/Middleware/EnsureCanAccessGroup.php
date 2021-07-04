<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleType;
use Closure;
use Illuminate\Http\Request;

class EnsureCanAccessGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $roleTypeValue)
    {
        $group = $request->route('group');
        $route = '';

        switch ($roleTypeValue) {
            case UserRoleType::Teacher:
                $route = 'teacher.groups.index';
                break;
            case UserRoleType::Student:
                $route = 'student.group.index';
                break;
        }

        if (!$group->canCurrentUserAccess($roleTypeValue)) {
            return redirect()
                ->route($route)
                ->with('error', 'Nie należysz do tej grupy.');
        }

        return $next($request);
    }
}
