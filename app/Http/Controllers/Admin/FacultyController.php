<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{

    public function index()
    {
        return view('admin.faculties.index', ['faculties' => Faculty::all()]);
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'code' => 'required|string|unique:faculties'
            ]);

        Faculty::create($validatedData);
        flash('Tworzenie wydziału powiodło się')->success();
        return redirect()->route('admin.faculties.index');

    }

    public function show(int $id)
    {
        return view('admin.faculties.show', ['faculty' => Faculty::findOrFail($id)]);
    }

    public function edit(int $id)
    {
        return view('admin.faculties.edit', ['faculty' => Faculty::findOrFail($id)]);
    }

    public function update(Request $request, int $id)
    {
        $currentFaculty = Faculty::findOrFail($id);

        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'code' => 'required|string|unique:faculties,code,'.$currentFaculty->id
            ]);

        $currentFaculty->update($validatedData);
        flash('Aktualizacja wydziału powiodła się')->success();
        return redirect()->route('admin.faculties.index');
    }

    public function destroy(int $id)
    {
        if (!Faculty::findOrFail($id)->delete()) {
            flash('Usuwanie wydziału nie powiodło się')->error();
        }

        flash('Usuwanie wydziału powiodło się')->success();
        return redirect()->route('admin.faculties.index');
    }
}
