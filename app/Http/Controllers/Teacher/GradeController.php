<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\GradeItem;
use App\Models\Group;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function index(int $groupId)
    {
        return view('teacher.grades.index', [
            'group' => $this->getStudentsGrades($groupId)['group'],
            'students' => $this->getStudentsGrades($groupId)['students'],
            'gradeItems' => $this->getStudentsGrades($groupId)['gradeItems'],
            'studentsGradeList' => $this->getStudentsGrades($groupId)['studentsGradeList'],
        ]);
    }

    public function create(int $groupId)
    {
        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];

        return view('teacher.grades.create', [
            'group' => $this->getStudentsGrades($groupId)['group'],
            'students' => $this->getStudentsGrades($groupId)['students'],
            'gradeValues' => $gradeValues
        ]);
    }

    public function store(Request $request, int $groupId)
    {
        $students = $this->getStudentsGrades($groupId)['students'];
        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];

        $validatedGradeItemData = $request->validate([
            'code' => 'required|string|size:3',
            'name' => 'required|string',
            'color' => 'required|string',
            'mark_weight' => 'required|integer',
            'max_score' => 'nullable|integer'
        ]);

        DB::beginTransaction();
        try {
            $gradeItem = GradeItem::create(array_merge($validatedGradeItemData, ['group_id' => $groupId]));

            foreach ($students as $student) {
                $studentGradeFieldName = $student->id . '-grade_value';
                $studentScoreFieldName = $student->id . '-score';
                $studentCommentFieldName = $student->id . '-comment';

                $validatedGradeData = $request->validate([
                    $studentGradeFieldName => [
                        'nullable',
                        Rule::in($gradeValues),
                    ],
                    $studentScoreFieldName => 'nullable|integer',
                    $studentCommentFieldName => 'nullable|string'
                ]);

                if ($validatedGradeData) {
                    Grade::create(array_merge($validatedGradeData, [
                        'grade_value' => $validatedGradeData[$studentGradeFieldName],
                        'score' => $validatedGradeData[$studentScoreFieldName],
                        'comment' => $validatedGradeData[$studentCommentFieldName],
                        'student_id' => $student->id,
                        'grade_item_id' => $gradeItem->id
                    ]));
                }
            }

            DB::commit();
            return redirect()->route('teacher.groups.grades.index', $groupId)->with('success', 'Dodawanie oceny powiodło się');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            return redirect()->route('teacher.groups.grades.index', $groupId)->with('errorr', 'Dodawanie oceny nie powiodło się');
        }
    }

    private function getStudentsGrades(int $groupId): array
    {
        $group = Group::findOrFail($groupId);
        $students = $group->students()->select(['students.id', 'user_id', 'users.first_name', 'users.last_name'])
            ->join('users', 'user_id', '=', 'users.id')
            ->orderBy('users.last_name')->orderBy('users.first_name')->get();
        $gradeItems = $group->gradeItems()->orderBy('created_at')->get();
        $groupGrades = Grade::whereHas('gradeItem', function (Builder $q) use ($groupId) {
            $q->where('group_id', '=', $groupId);
        })->get();

        $studentsGradeList = [];
        foreach ($students as $student) {
            $gradesList = [];
            foreach ($gradeItems as $gradeItem) {
                $grade = $groupGrades->where('grade_item_id', '=', $gradeItem->id)
                    ->where('student_id', '=', $student->id)->first();
                $gradesList[$gradeItem->id] = $grade;
            }
            $studentsGradeList[$student->id] = $gradesList;
        }
        return ['group' => $group, 'students' => $students, 'gradeItems' => $gradeItems, 'studentsGradeList' => $studentsGradeList];
    }
}
