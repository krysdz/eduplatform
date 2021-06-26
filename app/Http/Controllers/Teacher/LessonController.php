<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\ScheduledLesson;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function index(Group $group)
    {
        return view('teacher.lessons.index', [
            'group' => $group,
            'scheduledLesson' => ScheduledLesson::where(['group_id' => $group->id])->orderBy('date')->get(),
        ]);
    }

    public function create(Group $group)
    {
        $scheduledLesson = ScheduledLesson::findOrFail(request()->query('scheduledLesson'));

        return view('teacher.lessons.create', [
            'group' => $group,
            'scheduledLesson' => $scheduledLesson
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'scheduled_lesson_id' => 'required|integer|exists:scheduled_lessons,id',
            'number' => 'required|integer',
            'name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            if (Lesson::where('scheduled_lesson_id', '=', $validatedData['scheduled_lesson_id'])->exists()) {
                throw new Exception('Lekcja została już stworzona.');
            }

            Lesson::create($validatedData);

            DB::commit();

            return redirect()->route('teacher.groups.lessons.index', $group)->with('success', 'Tworzenie lekcji powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function show(Group $group, Lesson $lesson)
    {
        return view('teacher.lessons.show', [
            'group' => $group,
            'scheduledLesson' => $lesson->scheduleLesson,
            'lesson' => $lesson
        ]);
    }

    public function edit(Request $request, Group $group, Lesson $lesson)
    {
      return view('teacher.lessons.edit', [
            'group' => $group,
            'lesson' => $lesson
        ]);
    }


    public function update(Request $request, Group $group, Lesson $lesson)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer',
            'name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $lesson->update($validatedData);

            DB::commit();

            return redirect()->route('teacher.groups.lessons.index', $group)->with('success', 'Aktualizacja lekcji powiodła się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
