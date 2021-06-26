<?php

namespace App\Http\Controllers\Admin;

use App\Enums\GroupMemberType;
use App\Enums\GroupType;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Term;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;


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
            'types' => GroupType::asArray(),
            'teachers' => User::getTeachers(),
            'terms' => Term::all(),
            'students' => User::getStudents(),
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'number' => 'required|integer',
            'type' => 'required|integer',
            'term_id' => 'required|integer|exists:terms,id',
            'teachers' => 'required|array',
            'students' => 'required|array'
        ]);

        DB::beginTransaction();

        try {

            if(array_intersect($validatedData['students'], $validatedData['teachers'])) {
                throw new Exception('Użytkownik nie może posiadać ról Student i Teacher w tej samej grupie.');
            }

            $group = Group::create($validatedData);
            $group->groupMembers()->attach(User::find($validatedData['students']), ['type' => GroupMemberType::Student]);
            $group->groupMembers()->attach(User::find($validatedData['teachers']), ['type' => GroupMemberType::Teacher]);

            DB::commit();

            return redirect()->route('admin.groups.index')->with('success', 'Tworzenie grupy powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Group $group)
    {
        return view('admin.groups.show', [
            'group' => $group
        ]);
    }


    public function edit(Group $group)
    {
        return view('admin.groups.edit', [
            'group' => $group,
            'courses' => Course::all(),
            'types' => GroupType::asArray(),
            'teachers' => User::getTeachers(),
            'terms' => Term::all(),
            'students' => User::getStudents(),
        ]);
    }


    public function update(Request $request, Group $group)
    {

        $validatedData = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'number' => 'required|integer',
            'type' => 'required|integer',
            'term_id' => 'required|integer|exists:terms,id',
            'teachers' => 'required|array',
            'students' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            $group->update($validatedData);

            $students = array_fill_keys($validatedData['students'],
                ['type' => GroupMemberType::Student]);

            $teachers = array_fill_keys($validatedData['teachers'],
                ['type' => GroupMemberType::Teacher]);

            if(array_intersect_key($students, $teachers)) {
                throw new Exception('Użytkownik nie może posiadać ról Student i Teacher w tej samej grupie.');
            }

            $members = $students + $teachers;

            $group->groupMembers()->sync($members);
            DB::commit();

            return redirect()->route('admin.groups.index')
                ->with('success', 'Aktualizacja grupy powiodła się.');
        } catch (Throwable $e) {
            DB::rollback();
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

    }

    public function destroy(Group $group)
    {
        try {
            if (!$group->delete()) {
                throw new Exception( "Usuwanie grupy $group nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage());
        }


        return redirect()->route('admin.groups.index')->with('success', "Usuwanie grupy $group powiodło się.");
    }
}
