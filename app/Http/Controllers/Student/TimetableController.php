<?php

namespace App\Http\Controllers\Student;

use App\Enums\DayOfWeekType;
use App\Enums\GroupMemberType;
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
        $groupsSchedules = GroupSchedule::whereHas('group', function ($q) use ($term){
                $q->where('term_id', '=', $term->id)
                    ->whereHas('groupMembers', function ($q) {
                        $q->where([
                            'user_id' => Auth::user()->id,
                            'type' => GroupMemberType::Student,
                        ]);
                    });
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
