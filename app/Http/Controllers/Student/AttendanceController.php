<?php

namespace App\Http\Controllers\Student;

use App\Enums\AttendanceType;
use App\Enums\GroupMemberType;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $groups = Auth::user()->groups()->withPivot('type')->where(['group_members.type' => GroupMemberType::Student])->get();

        return view('modules.student.attendances.index', [
            'groups' => $groups,
            'studentAttendanceByGroup' => $this->getAnnouncementsByGroups($groups),
        ]);
    }

    private function getAnnouncementsByGroups($groups): array
    {
        $groupsAttendanceList = [];
        foreach ($groups as $group) {
            $attendanceList = [
                'items' => [],
                'total' => [
                    AttendanceType::Presence => 0,
                    AttendanceType::Absence => 0,
                    AttendanceType::Excused => 0,
                    AttendanceType::Late => 0,
                ],
            ];

            $attendances = Attendance::join('scheduled_lessons', 'attendances.scheduled_lesson_id', '=' , 'scheduled_lessons.id')
                ->where(['student_id' => Auth::user()->id])
                ->where(['scheduled_lessons.group_id' => $group->id])
                ->orderBy('scheduled_lessons.date')->get();

            foreach ($attendances as $attendance) {
                $attendanceList['items'][] = $attendance;

                $attendanceList['total'][$attendance->type->value]++;
            }

            $groupsAttendanceList[$group->id] = $attendanceList;
        }

        return $groupsAttendanceList;
    }
}

