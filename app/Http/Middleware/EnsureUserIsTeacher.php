<?php

namespace App\Http\Middleware;

use App\Models\Group;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnsureUserIsTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (($groupId = $request->route()->parameter('groupId')) != null) {
            $group = Group::find($groupId);

            if (!empty($group) && $group->teacher_id !== $user->teacher->id) {
                return Redirect::route('login');
            }
        }

        if (($lessonId = $request->route()->parameter('lessonId')) != null) {
            $lesson = Lesson::find($lessonId);

            if (!empty($lesson) && $lesson->group->teacher_id !== $user->teacher->id) {
                return Redirect::route('login');
            }
        }

        return $next($request);
    }
}
