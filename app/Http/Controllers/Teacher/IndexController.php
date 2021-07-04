<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\UserRoleType;
use App\Http\Controllers\Controller;
use App\Models\ScheduledLesson;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $todayScheduledLessons = ScheduledLesson::where([
            'teacher_id' => Auth::id(),
            'date' => $today
        ])->orderBy('start_time')->get();

        $tomorrowScheduledLessons = ScheduledLesson::where([
            'teacher_id' => Auth::id(),
            'date' => $tomorrow
        ])->orderBy('start_time')->get();

        return view('modules.teacher.index', [
            'today' => $today,
            'tomorrow' => $tomorrow,
            'todayScheduledLessons' => $todayScheduledLessons,
            'tomorrowScheduledLessons' => $tomorrowScheduledLessons
        ]);
    }
}
