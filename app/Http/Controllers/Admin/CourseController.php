<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class CourseController extends Controller
{

    public function index()
    {
        return view('modules.administrator.courses.index', [
            'courses' => Course::orderBy('name')->get()
        ]);
    }


    public function create()
    {
        return view('modules.administrator.courses.create', [
            'faculties' => Faculty::orderBy('name')->get(),
            'teachers' => User::getTeachers()->sortBy(['last_name'], ['first_name'])
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses',
            'faculty_id' => 'required|integer|exists:faculties,id',
            'coordinator_id' => 'required|integer|exists:users,id',
            'description' => 'nullable|string'
        ]);

        try {
            Course::create($validatedData);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.courses.index')->with('success', 'Tworzenie kursu powiodło się.');
    }


    public function show(Course $course)
    {
        return view('modules.administrator.courses.show', [
            'course' => $course
        ]);
    }


    public function edit(Course $course)
    {
        return view('modules.administrator.courses.edit', [
            'course' => $course,
            'faculties' => Faculty::orderBy('name')->get(),
            'teachers' => User::getTeachers()->sortBy(['last_name'], ['first_name'])
        ]);
    }


    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'faculty_id' => 'required|integer|exists:faculties,id',
            'coordinator_id' => 'required|integer|exists:users,id',
            'description' => 'nullable|string'
        ]);

        try {
            $course->update($validatedData);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.courses.index')->with('success', 'Aktualizacja kursu powiodło się.');
    }

    public function destroy(Course $course)
    {
        try {
            if (!$course->delete()) {
                throw new Exception("Usuwanie kursu $course nie powiodło się");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.courses.index')->with('success', "Usuwanie kursu $course powiodło się");
    }
}
