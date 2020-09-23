<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lesson;
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
        return view('teacher.lessons.edit', [
            'lesson' => Lesson::findOrFail($lessonId),
            'action' => $request->input('action')
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
                    'description' => 'nullable|string',
                    'is_active' => 'sometimes|string'
                ]);
                $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');
                break;
        }

        $currentLesson->update($validatedData);
        flash('Tworzenie lekcji powiodło się')->success();
        return redirect()->route('teacher.groups.lessons.index', $currentLesson->group_id);
    }
}
