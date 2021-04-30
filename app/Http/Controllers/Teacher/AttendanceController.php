<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\AttendanceType;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(int $groupId)
    {
        list($group, $students, $lessons, $studentsAttendanceList) = $this->getStudentsAttendanceList($groupId);

        return view('teacher.attendances.index', [
            'group' => $group,
            'students' => $students,
            'lessons' => $lessons,
            'studentsAttendanceList' => $studentsAttendanceList
        ]);
    }

    public function edit(int $groupId)
    {
        list($group, $students, $lessons, $studentsAttendanceList) = $this->getStudentsAttendanceList($groupId);

        return view('teacher.attendances.edit', [
            'group' => $group,
            'students' => $students,
            'lessons' => $lessons,
            'studentsAttendanceList' => $studentsAttendanceList,
            'types' => AttendanceType::toArray(),
        ]);
    }

    public function update(Request $request, int $groupId)
    {
        $group = Group::findOrFail($groupId);
        $students = $group->students()->select(['students.id', 'user_id', 'users.first_name', 'users.last_name'])
            ->join('users', 'user_id', '=', 'users.id')
            ->orderBy('users.last_name')->orderBy('users.first_name')->get();
        $lessons = $group->lessons()->select(['id', 'date'])->where('is_active', '=', 1)->orderBy('date')->get();

        DB::beginTransaction();
        try {
            foreach ($lessons as $lesson) {
                foreach ($students as $student) {
                    // studentId-lessonId
                    $fieldInputName = $student->id . '-' . $lesson->id;
                    $validatedData = $request->validate([
                        $fieldInputName => 'nullable|integer'
                    ]);

                    if ($validatedData[$fieldInputName]) {
                        $validatedData[$fieldInputName] = AttendanceType::makeFromId($validatedData[$fieldInputName]);

                        Attendance::updateOrCreate([
                            'lesson_id' => $lesson->id,
                            'student_id' => $student->id],
                            ['type' => $validatedData[$fieldInputName]]);
                    }
                }
            }
            DB::commit();
//            flash('Edycja frekwencji powiodła się')->success();
            return redirect()->route('teacher.groups.attendances.index', $groupId)->with('success', 'Edycja frekwencji powiodła się');
        } catch (Exception $e) {
            DB::rollback();
            flash('Edycja frekwencji nie powiodła się')->error();
            return redirect()->route('teacher.groups.attendances.index', $groupId);
        }
    }

    private function getStudentsAttendanceList(int $groupId): array
    {
        $group = Group::findOrFail($groupId);
        $students = $group->students()->select(['students.id', 'user_id', 'users.first_name', 'users.last_name'])
            ->join('users', 'user_id', '=', 'users.id')
            ->orderBy('users.last_name')->orderBy('users.first_name')->get();
        $lessons = $group->lessons()->select(['id', 'date'])->where('is_active', '=', 1)->orderBy('date')->get();
        $groupAttendance = Attendance::select(['attendances.created_at', 'attendances.updated_at',
            'attendances.lesson_id', 'attendances.student_id', 'lessons.group_id', 'attendances.type'])
            ->join('lessons', 'lesson_id', '=', 'lessons.id')
            ->where(['lessons.group_id' => $groupId])->get();

        $studentsAttendanceList = [];
        foreach ($students as $student) {
            $attendanceList = [];
            foreach ($lessons as $lesson) {
                $attendance = $groupAttendance->where('lesson_id', '=', $lesson->id)
                    ->where('student_id', '=', $student->id)->first();
                $attendanceList[$lesson->id] = $attendance;
            }
            $studentsAttendanceList[$student->id] = $attendanceList;
        }
        return array($group, $students, $lessons, $studentsAttendanceList);
    }
}
