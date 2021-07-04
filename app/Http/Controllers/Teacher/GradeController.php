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
    public function index(Group $group)
    {
        list($students, $gradeItems, $studentsGradeList) = $this->getStudentsGrades($group);

        return view('modules.teacher.grades.index', [
            'group' => $group,
            'students' => $students,
            'gradeItems' => $gradeItems,
            'studentsGradeList' => $studentsGradeList,
        ]);
    }

    public function create(Group $group)
    {
        list($students, $gradeItems, $studentsGradeList) = $this->getStudentsGrades($group);
        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];
        $colors = [
            '#000000' => 'Czarny',
            '#F44336' => 'Czerwony',
            '#2196F3' => 'Niebieski',
            '#4CAF50' => 'Zielony'
        ];

        return view('modules.teacher.grades.create', [
            'group' => $group,
            'students' => $students,
            'gradeValues' => $gradeValues,
            'colors' => $colors
        ]);
    }

    public function store(Request $request, Group $group)
    {
        list($students, $gradeItems, $studentsGradeList) = $this->getStudentsGrades($group);
        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];

        $validatedGradeItemData = $request->validate([
            'code' => 'required|string|max:3',
            'name' => 'required|string',
            'color' => 'required|string',
            'weight' => 'required|integer',
            'maxscore' => 'nullable|integer'
        ]);

        DB::beginTransaction();
        try {
            $gradeItem = GradeItem::create(array_merge($validatedGradeItemData, ['group_id' => $group->id]));

            foreach ($students as $student) {
                $studentGradeFieldName = $student->id . '-grade_value';
                $studentScoreFieldName = $student->id . '-score';
                $studentCommentFieldName = $student->id . '-comment';

                $validatedGradeData = $request->validate([
                    $studentGradeFieldName => [
                        'nullable',
                        Rule::in($gradeValues),
                    ],
                    $studentScoreFieldName => "nullable|integer|lte:".$validatedGradeItemData['maxscore'],
                    $studentCommentFieldName => 'nullable|string'
                ]);

                if(!is_null($validatedGradeData[$studentGradeFieldName]) || !is_null($validatedGradeData[$studentScoreFieldName])) {
                    Grade::create([
                        'student_id' => $student->id,
                        'grade_item_id' => $gradeItem->id,
                        'grade' => $validatedGradeData[$studentGradeFieldName],
                        'score' => $validatedGradeData[$studentScoreFieldName],
                        'comment' => $validatedGradeData[$studentCommentFieldName],
                    ]);
                }

            }

            DB::commit();
            return redirect()->route('teacher.groups.grades.index', $group)->with('success', 'Dodanie oceny powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(Request $request, Group $group, GradeItem $gradeItem)
    {
        list($students, $gradeItems, $studentsGradeList) = $this->getStudentsGrades($group);
        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];
        $colors = [
            '#000000' => 'Czarny',
            '#F44336' => 'Czerwony',
            '#2196F3' => 'Niebieski',
            '#4CAF50' => 'Zielony'
        ];

        return view('modules.teacher.grades.edit', [
            'gradeItem' => $gradeItem,
            'studentsGradeList' => $this->getStudentsGradeByGradeItemId($group, $gradeItem, $students),
            'group' => $group,
            'students' => $students,
            'gradeValues' => $gradeValues,
            'colors' => $colors
        ]);
    }

    public function update(Request $request, Group $group, GradeItem $gradeItem)
    {
        list($students, $gradeItems, $studentsGradeList) = $this->getStudentsGrades($group);

        $gradeValues = ['5.0', '4.5', '4.0', '3.5', '3.0', '2.0', 'NZAL'];

        $validatedGradeItemData = $request->validate([
            'code' => 'required|string|max:3',
            'name' => 'required|string',
            'color' => 'required|string',
            'weight' => 'required|integer',
            'maxscore' => 'nullable|integer'
        ]);

        DB::beginTransaction();

        try {
            $gradeItem->update($validatedGradeItemData);

            foreach ($students as $student) {
                    $studentGradeFieldName = $student->id . '-grade_value';
                    $studentScoreFieldName = $student->id . '-score';
                    $studentCommentFieldName = $student->id . '-comment';

                    $validatedGradeData = $request->validate([
                        $studentGradeFieldName => [
                            'nullable',
                            Rule::in($gradeValues),
                        ],
                        $studentScoreFieldName => "nullable|integer|lte:".$validatedGradeItemData['maxscore'],
                        $studentCommentFieldName => 'nullable|string'
                    ]);


                    if(!is_null($validatedGradeData[$studentGradeFieldName]) || !is_null($validatedGradeData[$studentScoreFieldName])) {
                        Grade::updateOrCreate([
                            'student_id' => $student->id,
                            'grade_item_id' => $gradeItem->id,
                        ], [
                            'grade' => $validatedGradeData[$studentGradeFieldName],
                            'score' => $validatedGradeData[$studentScoreFieldName],
                            'comment' => $validatedGradeData[$studentCommentFieldName],
                        ]);
                    }
                }

            DB::commit();
            return redirect()->route('teacher.groups.grades.index', $group)->with('success', 'Edycja oceny powiodła się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    private function getStudentsGrades(Group $group): array
    {
        $students = $group->students()->sortBy(function ($student) {
            return $student->last_name . ' ' . $student->first_name;
        });

        $gradeItems = $group->gradeItems()->orderBy('created_at')->get();

        $groupGrades = Grade::whereHas('gradeItem', function (Builder $q) use ($group) {
            $q->where('group_id', '=', $group->id);
        })->get();

        $studentsGradeList = [];
        foreach ($students as $student) {
            $gradesList = [
                'items' => [],
                'total' => [
                    'grade_sum' => 0,
                    'grade_weight' => 0,
                    'score_sum' => 0,
                    'score_max' => 0
                ]
            ];
            foreach ($gradeItems as $gradeItem) {
                $grade = $groupGrades->where('grade_item_id', '=', $gradeItem->id)
                    ->where('student_id', '=', $student->id)->first();
                $gradesList['items'][$gradeItem->id] = $grade;

                if(!empty($grade)) {
                    if($grade->grade && $grade->grade !== 'NZAL') {
                        $gradesList['total']['grade_sum'] += ($grade->grade * $gradeItem->weight);
                        $gradesList['total']['grade_weight'] += $gradeItem->weight;
                    }
                    if(!is_null($grade->score)) {
                        $gradesList['total']['score_sum'] += $grade->score;
                        $gradesList['total']['score_max'] += $gradeItem->maxscore;
                    }

                }
            }
            $studentsGradeList[$student->id] = $gradesList;
        }

        return array($students, $gradeItems, $studentsGradeList);
    }

    function getStudentsGradeByGradeItemId(Group $group, GradeItem $gradeItem, $students): array
    {
        $groupGrades = Grade::where('grade_item_id', '=', $gradeItem->id)->get();

        $studentsGradeList = [];
        foreach ($students as $student) {
            $grade = $groupGrades->where('student_id', '=', $student->id)->first();
            $studentsGradeList[$student->id] = $grade;
        }
        return $studentsGradeList;
    }
}
