<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
//        $today = Carbon::createFromDate(2020,02,28)->toDateString();
        $lessons = Lesson::whereHas('group', function (Builder $q) {
            $q->where(['teacher_id' => request()->user()->teacher->id]);
        })->where(['date' => $today])->get();

        return view('teacher.index', [
            'today' => $today,
            'lessons' => $lessons
        ]);
    }
}
