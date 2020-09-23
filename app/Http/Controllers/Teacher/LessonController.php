<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(int $groupId)
    {
        return view('teacher.lessons.index', [
            'lessons' => Lesson::where(['group_id' => $groupId])->get(),
        ]);
    }

    public function show(int $lessonId)
    {
        return view('teacher.lessons.show', [
            'lesson' => Lesson::findOrFail($lessonId)
        ]);
    }


    public function edit(Request $request, int $lessonId)
    {
        $action = $request->input('action');

        if (!in_array($action, ['edit', 'plan', 'create'])) {
            flash('Nie możesz wykonać żądanej akcji')->error();
            return redirect()->back();
        }

        return view('teacher.lessons.edit', [
            'lesson' => Lesson::findOrFail($lessonId),
            'action' => $action
        ]);
    }


    public function update(Request $request, int $lessonId)
    {
        $currentLesson = Lesson::findOrFail($lessonId);
        $action = $request->input('action');
        $validatedData = [];

        switch ($action) {
            case 'publish':
                $validatedData['is_active'] = true;
                break;
            case 'clear':
                $validatedData = [
                    'title' => null,
                    'description' => null,
                    'is_active' => false
                ];
                break;
            default:
                $validatedData = $request->validate([
                    'title' => 'required|string',
                    'date' => 'required|date',
                    'number' => 'required|integer',
                    'is_active' => 'sometimes|string'
                ]);
                $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');
                break;
        }

        $currentLesson->update($validatedData);

        if($currentLesson->is_active && Section::where(['lesson_id' => $currentLesson->id])->doesntExist()) {
            Section::create([
                'title' => $currentLesson->title,
                'lesson_id' => $currentLesson->id,
                'group_id' => $currentLesson->group_id,
                'is_active' => false,
                'position' => $currentLesson->id * 10
            ]);
        }

        flash('Tworzenie lekcji powiodło się')->success();
        return redirect()->route('teacher.groups.lessons.index', $currentLesson->group_id);
    }
}
