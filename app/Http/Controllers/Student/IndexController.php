<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ScheduledLesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $todayScheduledLessons = ScheduledLesson::where(['date' => $today])
            ->whereIn('group_id', Auth::user()->groups)
            ->orderBy('start_time')->get();

        return view('modules.student.index', [
            'today' => $today,
            'todayScheduledLessons' => $todayScheduledLessons,
            'notifications' => auth()->user()->notifications
        ]);
    }

}
