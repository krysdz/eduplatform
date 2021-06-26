<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\AttendanceType;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Group $group)
    {
        list($students, $scheduledLessons, $studentsAttendanceList) = $this->getStudentsAttendanceList($group);

        return view('teacher.attendances.index', [
            'group' => $group,
            'students' => $students,
            'scheduledLessons' => $scheduledLessons,
            'studentsAttendanceList' => $studentsAttendanceList,
            'attendanceTypes' => AttendanceType::asArray()
        ]);
    }

    public function edit(Group $group)
    {
        list($students, $scheduledLessons, $studentsAttendanceList) = $this->getStudentsAttendanceList($group);

        return view('teacher.attendances.edit', [
            'group' => $group,
            'students' => $students,
            'scheduledLessons' => $scheduledLessons,
            'studentsAttendanceList' => $studentsAttendanceList,
            'attendanceTypes' => AttendanceType::asArray()
        ]);
    }

    public function update(Request $request, Group $group)
    {
        list($students, $scheduledLessons, $studentsAttendanceList) = $this->getStudentsAttendanceList($group);

        DB::beginTransaction();

        try {
            foreach ($scheduledLessons as $lesson) {
                $hasScheduledLessonUpdated = false;
                $attendancesToUpdate = [];

                foreach ($students as $student) {
                    $fieldInputName = $student->id . '-' . $lesson->id;
                    $validatedData = $request->validate([$fieldInputName => 'nullable|integer']);

                    if (!empty($validatedData[$fieldInputName])) {
                        $hasScheduledLessonUpdated = true;
                    }

                    $selectedAttendanceType = $validatedData[$fieldInputName] ?? AttendanceType::Presence;
                    $studentAttendance = $studentsAttendanceList[$student->id]['items'][$lesson->id];

                    if (is_null($studentAttendance)) {
                        $studentAttendance = new Attendance();
                        $studentAttendance->fill([
                            'student_id' => $student->id,
                            'scheduled_lesson_id' => $lesson->id,
                        ]);
                    }

                    if ($studentAttendance->type !== $selectedAttendanceType) {
                        $studentAttendance->type = $selectedAttendanceType;

                        $attendancesToUpdate[] = $studentAttendance;
                    }
                }

                if (!$hasScheduledLessonUpdated) {
                    continue;
                }

                foreach ($attendancesToUpdate as $attendance) {
                    $attendance->save();
                }
            }

            DB::commit();

            return redirect()->route('teacher.groups.attendances.index', $group)->with('success', 'Edycja frekwencji powiodła się');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    private function getStudentsAttendanceList(Group $group): array
    {
        $students = $group->students()->sortBy(function ($student) {
            return $student->last_name . ' ' . $student->first_name;
        });

        $scheduledLessons = $group->scheduledLessons()->orderBy('date')->get();
        $groupAttendance = Attendance::whereHas('scheduledLesson', function ($q) use ($group) {
            $q->where('group_id', '=', $group->id);
        })->get();

        $studentsAttendanceList = [];
        foreach ($students as $student) {
            $attendanceList = [
                'items' => [],
                'total' => [
                    AttendanceType::Presence => 0,
                    AttendanceType::Absence => 0,
                    AttendanceType::Excused => 0,
                    AttendanceType::Late => 0,
                ],
            ];

            foreach ($scheduledLessons as $scheduledLesson) {
                $attendance = $groupAttendance
                    ->where('scheduled_lesson_id', '=', $scheduledLesson->id)
                    ->where('student_id', '=', $student->id)->first();

                $attendanceList['items'][$scheduledLesson->id] = $attendance;

                if (!empty($attendance)) {
                    $attendanceList['total'][$attendance->type->value]++;
                }
            }

            $studentsAttendanceList[$student->id] = $attendanceList;
        }

        return array($students, $scheduledLessons, $studentsAttendanceList);
    }
}
