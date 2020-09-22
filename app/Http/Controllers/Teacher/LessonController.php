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


    public function create()
    {
//
    }


    public function store(Request $request)
    {
      //
    }


    public function show(int $lessonId)
    {
        // TODO: sprawdzenie grupy
        return view('teacher.lessons.show', [
            'lesson' => Lesson::findOrFail($lessonId)
        ]);
    }


    public function edit(int $id)
    {
        //
    }


    public function update(Request $request, int $id)
    {
        //

    }

    public function destroy($id)
    {
       //
    }
}
