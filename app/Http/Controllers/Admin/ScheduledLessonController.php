<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\ScheduledLesson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class ScheduledLessonController extends Controller
{
    public function index(Group $group)
    {
        return view('admin.scheduled_lessons.index', [
            'group' => $group,
            'scheduled_lessons' => ScheduledLesson::where(['group_id' => $group->id])->orderBy('date')->get(),
        ]);
    }

    public function generate(Group $group)
    {
        DB::beginTransaction();

        try {
            if (ScheduledLesson::where(['group_id' => $group->id])->exists()) {
                throw new Exception("Planowane lekcje dla grupy $group zostały już wygenerowane.");
            }

            foreach ($group->groupSchedules()->get() as $schedule) {
                $firstDate = Carbon::create($schedule->first_date);
                $lastDate = Carbon::create($schedule->last_date);

                while ($firstDate->dayOfWeekIso != $schedule->day_of_week_type->value) {
                    $firstDate->addDay();
                }

                while ($firstDate->lessThanOrEqualTo($lastDate)) {
                    $date = clone $firstDate;

                    ScheduledLesson::create([
                        'group_schedule_id' => $schedule->id,
                        'group_id' => $group->id,
                        'teacher_id' => $schedule->teacher_id,
                        'date' => $date,
                        'start_time' => $schedule->start_time,
                        'end_time' => $schedule->end_time,
                        'room_name' => $schedule->room_name
                    ]);

                    $firstDate->addDays($schedule->interval_days);
                }
            }

            DB::commit();

            return redirect()->route('admin.groups.scheduled_lessons.index', $group)->with('success', "Generowanie planowanych lekcji dla grupy $group powiodło się.");

        } catch (Throwable $e) {
            DB::rollback();
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
