<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DayOfWeekType;
use App\Enums\GroupType;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\ScheduledLesson;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;
use function Sodium\add;

class GroupScheduleController extends Controller
{
    public function index(Group $group)
    {
        return view('admin.group_schedules.index', [
            'group' => $group,
            'group_schedules' => GroupSchedule::where(['group_id' => $group->id])->get()
        ]);
    }

    public function create(Group $group)
    {
        return view('admin.group_schedules.create', [
            'group' => $group,
            'day_of_week_type' => DayOfWeekType::asArray(),
            'teachers' => $group->teachers(),
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'day_of_week_type' => 'required|integer',
            'interval_days' => 'required|integer',
            'first_date' => 'required|date',
            'last_date' => 'required|date|after_or_equal:first_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'teacher_id' => 'required|integer|exists:users,id',
            'room_name' => 'required|string'
        ]);

        try {
            GroupSchedule::create(array_merge($validatedData, ['group_id' => $group->id]));
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('admin.groups.group_schedules.index', $group)->with('success', "Tworzenie harmonogramu dla grupy $group powiodło się.");
    }

    public function show(Group $group, GroupSchedule $groupSchedule)
    {
        return view('admin.group_schedules.show', [
            'group_schedule' => $groupSchedule,
            'group' => $group
        ]);
    }


    public function edit(Group $group, GroupSchedule $groupSchedule)
    {
        return view('admin.group_schedules.edit', [
            'group_schedule' => $groupSchedule,
            'group' => $group,
            'day_of_week_type' => DayOfWeekType::asArray(),
            'teachers' => $group->teachers()
        ]);
    }


    public function update(Request $request, Group $group, GroupSchedule $groupSchedule)
    {

        $validatedData = $request->validate([
            'day_of_week_type' => 'required|integer',
            'interval_days' => 'required|integer',
            'first_date' => 'required|date',
            'last_date' => 'required|date|after_or_equal:first_date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'teacher_id' => 'required|integer|exists:users,id',
            'room_name' => 'required|string'
        ]);

        try {
            $groupSchedule->update(array_merge($validatedData));
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('admin.groups.group_schedules.index', $group)->with('success', "Aktualizacja harmonogramu dla grupy $group powiodło się.");

    }

    public function destroy(Group $group, GroupSchedule $groupSchedule)
    {
        try {
            if (!$groupSchedule->delete()) {
                throw new Exception("Usuwanie harmonogramu dla $group nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('admin.groups.group_schedules.index', $group)->with('success', "Usuwanie harmonogramu dla $group powiodło się.");
    }

}
