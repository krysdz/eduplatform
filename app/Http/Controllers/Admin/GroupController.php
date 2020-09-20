<?php

namespace App\Http\Controllers\Admin;

use App\Enums\GroupTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Term;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GroupController extends Controller
{
    public function index()
    {
        return view('admin.groups.index', [
            'groups' => Group::all()
        ]);
    }


    public function create()
    {
        return view('admin.groups.create', [
            'courses' => Course::all(),
            'types' => GroupTypeEnum::toArray(),
            'teachers' => Teacher::all(),
            'terms' => Term::all(),
            'students' => Student::all()
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|integer',
            'number' => 'required|integer',
            'type' => 'required|string',
            'teacher_id' => 'required|integer',
            'term_id' => 'required|integer'
        ]);

        $validatedData['type'] = GroupTypeEnum::makeFromId($validatedData['type']);
        DB::beginTransaction();

        try {
            $group = Group::create($validatedData);
            $group->students()->attach(Student::find($request->input('students')));
            DB::commit();
            flash('Tworzenie grupy powiodło się')->success();
            return redirect()->route('admin.groups.index');
        } catch (Exception $e) {
            DB::rollback();
            flash('Tworzenie grupy nie powiodło się - rollback')->error();
            return redirect()->route('admin.groups.index');
        }
    }


    public function show(int $id)
    {
        return view('admin.groups.show', [
            'group' => Group::findOrFail($id)
        ]);
    }


    public function edit(int $id)
    {
        return view('admin.groups.edit', [
            'group' => Group::findOrFail($id),
            'courses' => Course::all(),
            'types' => GroupTypeEnum::toArray(),
            'teachers' => Teacher::all(),
            'terms' => Term::all(),
            'students' => Student::all()
        ]);
    }


    public function update(Request $request, int $id)
    {
        $currentGroup = Group::findOrFail($id);

        $validatedData = $request->validate([
            'course_id' => 'required|integer',
            'number' => 'required|integer',
            'type' => 'required|string',
            'teacher_id' => 'required|integer',
            'term_id' => 'required|integer'
        ]);

        $validatedData['type'] = GroupTypeEnum::makeFromId($validatedData['type']);
        DB::beginTransaction();

        try {
            $currentGroup->update($validatedData);
            $currentGroup->students()->detach();
            $currentGroup->students()->attach(Student::find($request->input('students')));
            DB::commit();
            flash('Aktualizacja grupy powiodła się')->success();
            return redirect()->route('admin.groups.index');
        } catch (Exception $e) {
            DB::rollback();
            flash('Aktualizacja grupy nie powiodła się - rollback')->error();
            return redirect()->route('admin.groups.index');
        }

    }

    public function destroy($id)
    {
        if (!Group::findOrFail($id)->delete()) {
            flash('Usuwanie grupy nie powiodło się')->error();
        }

        flash('Usuwanie grupy powiodło się')->success();
        return redirect()->route('admin.groups.index');
    }
}
