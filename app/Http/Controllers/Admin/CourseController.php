<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Faculty;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
        return view('admin.courses.index', [
            'courses' => Course::all()
        ]);
    }


    public function create()
    {
        return view('admin.courses.create', [
            'faculties' => Faculty::all()
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses',
            'faculty_id' => 'required|integer'
        ]);

        if (!$validatedData) {
            flash('Tworzenie kursu nie powiodło się')->error();
            return redirect()->back();
        }

        Course::create($validatedData);
        flash('Tworzenie kursu powiodło się')->success();
        return redirect()->route('admin.courses.index');
    }


    public function show(int $id)
    {
        return view('admin.courses.show', [
            'course' => Course::findOrFail($id)
        ]);
    }


    public function edit(int $id)
    {
        return view('admin.courses.edit', [
            'course' => Course::findOrFail($id),
            'faculties' => Faculty::all()
        ]);
    }


    public function update(Request $request, $id)
    {
        $currentCourse = Course::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses,code,'.$currentCourse->id,
            'faculty_id' => 'required|integer'
        ]);

        if (!$validatedData) {
            flash('Aktualizacja kursu nie powiodła się')->error();
            return redirect()->route('admin.courses.index');
        }

        $currentCourse->update($validatedData);
        flash('Aktualizacja kursu powiodła się')->success();
        return redirect()->route('admin.courses.index');

    }

    public function destroy($id)
    {
        if (!Course::findOrFail($id)->delete()) {
            flash('Usuwanie kursu nie powiodło się')->error();
        }

        flash('Usuwanie kursu powiodło się')->success();
        return redirect()->route('admin.courses.index');
    }
}
