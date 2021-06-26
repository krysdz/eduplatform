<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\ScheduledLesson;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $scheduledLessons = ScheduledLesson::where([
            'teacher_id' => Auth::id(),
            'date' => $today
        ])->orderBy('start_time')->get();

        return view('teacher.index', [
            'today' => $today,
            'scheduledLessons' => $scheduledLessons
        ]);
    }
}
