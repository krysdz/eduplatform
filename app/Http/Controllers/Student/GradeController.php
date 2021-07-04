<?php

namespace App\Http\Controllers\Student;

use App\Enums\GroupMemberType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $groups = Auth::user()->groups()->withPivot('type')->where(['group_members.type' => GroupMemberType::Student])->get();

        return view('modules.student.grades.index', [
            'groups' => $groups,
            'studentGradesByGroups' => $this->getStudentsGrades($groups),
        ]);
    }

    private function getStudentsGrades($groups): array
    {
        $groupsGradeList = [];
        foreach ($groups as $group) {
            $gradesList = [
                'items' => [],
                'total' => [
                    'average_grade' => 0,
                    'score_sum' => 0,
                    'score_max' => 0
                ]
            ];

            $grades = Auth::user()->grades()->whereHas('gradeItem', function ($q) use ($group) {
                $q->where('group_id', '=', $group->id);
            })->get();

            $gradeSum = 0;
            $gradeWeight = 0;

            foreach ($grades as $grade) {
                $gradesList['items'][] = $grade;

                if($grade->grade && $grade->grade !== 'NZAL') {
                    $gradeSum += ($grade->grade * $grade->gradeItem->weight);
                    $gradeWeight += $grade->gradeItem->weight;
                }

                if(!is_null($grade->score)) {
                    $gradesList['total']['score_sum'] += $grade->score;
                    $gradesList['total']['score_max'] += $grade->gradeItem->maxscore;
                }
            }
            if($gradeWeight > 0) {
                $gradesList['total']['average_grade'] = $gradeSum / $gradeWeight;
            }

            $groupsGradeList[$group->id] = $gradesList;
        }

        return $groupsGradeList;
    }
}
