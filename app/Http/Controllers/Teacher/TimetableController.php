<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\DayOfWeekType;
use App\Http\Controllers\Controller;
use App\Models\GroupSchedule;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $term = Term::getActiveTerm();
        $groupsSchedules = GroupSchedule::where('teacher_id', '=', Auth::user()->id)
            ->whereHas('group', function ($q) use ($term){
                $q->where('term_id', '=', $term->id);
            })->orderBy('day_of_week_type')->orderBy('start_time')->get()->groupBy(function (GroupSchedule $item) {
                return $item->day_of_week_type->value;
            });

        return view('shared.timetable', [
            'daysOfWeek' => DayOfWeekType::asArray(),
            'term' => $term,
            'groupsSchedules' => $groupsSchedules,
        ]);
    }
}
