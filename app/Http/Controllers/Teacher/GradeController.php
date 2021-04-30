<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\GradeItem;
use App\Models\Group;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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
            'code' => 'required|string|max:3',
            'name' => 'required|string',
            'color' => 'required|string',
            'mark_weight' => 'required|integer',
            'max_score' => 'nullable|integer'
        ]);

        DB::beginTransaction();
        try {
            $gradeItem = GradeItem::create(array_merge($validatedGradeItemData, ['group_id' => $groupId]));

            foreach ($students as $student) {
//                $user = User::find($student->user->id);

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

                if ($validatedGradeData[$studentGradeFieldName]) {
                    Grade::create([
                        'grade_value' => $validatedGradeData[$studentGradeFieldName],
                        'score' => $validatedGradeData[$studentScoreFieldName],
                        'comment' => $validatedGradeData[$studentCommentFieldName],
                        'student_id' => $student->id,
                        'grade_item_id' => $gradeItem->id
                    ]);
//                    dd($student->user);
                    $student->user->notify(new \App\Notifications\Grade($gradeItem->id, $validatedGradeData[$studentGradeFieldName]));
                }



            }

            DB::commit();
            return redirect()->route('teacher.groups.grades.index', $groupId)->with('success', 'Dodawanie oceny powiodło się');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('teacher.groups.grades.index', $groupId)->with('error', 'Dodawanie oceny nie powiodło się');
        }
    }

    public function edit(Request $request, int $gradeItemId)
    {
        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];
        $gradeItem = GradeItem::findOrFail($gradeItemId);


        return view('teacher.grades.edit', [
            'gradeItem' => $gradeItem,
            'studentsGradeList' => $this->getStudentsGradeByGradeItemId($gradeItem->group_id, $gradeItemId)['studentsGradeList'],
            'group' => $this->getStudentsGrades($gradeItem->group_id)['group'],
            'students' => $this->getStudentsGrades($gradeItem->group_id)['students'],
            'gradeValues' => $gradeValues,
        ]);
    }

//    public function edit(Request $request, int $gradeItemId)
//    {
//        $gradeItem = GradeItem::findOrFail($gradeItemId);
//
//        return view('teacher.grades.edit', [
//            'gradeItem' => $gradeItem,
//            'group' => $this->getStudentsGrades($gradeItem->group_id)['group'],
//            'students' => $this->getStudentsGrades($gradeItem->group_id)['students'],
//        ]);
//    }

    public function update(Request $request, int $gradeItemId)
    {
        $currentGradeItem = GradeItem::findOrFail($gradeItemId);
        $groupId = $currentGradeItem->group_id;
        $students = $this->getStudentsGrades($groupId)['students'];

        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];

        $validatedGradeItemData = $request->validate([
            'code' => 'required|string|max:3',
            'name' => 'required|string',
            'color' => 'required|string',
            'mark_weight' => 'required|integer',
            'max_score' => 'nullable|integer'
        ]);

        DB::beginTransaction();

        try {
            $currentGradeItem->update($validatedGradeItemData);

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

                    if ($validatedGradeData[$studentGradeFieldName]) {
                        Grade::updateOrCreate([
                            'student_id' => $student->id,
                            'grade_item_id' => $currentGradeItem->id], [
                            'grade_value' => $validatedGradeData[$studentGradeFieldName],
                            'score' => $validatedGradeData[$studentScoreFieldName],
                            'comment' => $validatedGradeData[$studentCommentFieldName],
                        ]);
                    }
                }

            DB::commit();
            return redirect()->route('teacher.groups.grades.index', $groupId)->with('success', 'Aktualizacja oceny powiodła się');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('teacher.groups.grades.index', $groupId)->with('errorr', 'Aktualizacja oceny nie powiodła się');
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

    function getStudentsGradeByGradeItemId(int $groupId, $gradeItemId): array
    {
        $group = Group::findOrFail($groupId);
        $students = $group->students()->select(['students.id', 'user_id', 'users.first_name', 'users.last_name'])
            ->join('users', 'user_id', '=', 'users.id')
            ->orderBy('users.last_name')->orderBy('users.first_name')->get();
        $groupGrades = Grade::where('grade_item_id', '=', $gradeItemId)->get();

        $studentsGradeList = [];
        foreach ($students as $student) {
            $grade = $groupGrades->where('student_id', '=', $student->id)->first();
            $studentsGradeList[$student->id] = $grade;
        }
        return ['group' => $group, 'students' => $students, 'studentsGradeList' => $studentsGradeList];
    }
}
