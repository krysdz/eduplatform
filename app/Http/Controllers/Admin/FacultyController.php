<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class FacultyController extends Controller
{

    public function index()
    {
        return view('modules.administrator.faculties.index', ['faculties' => Faculty::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('modules.administrator.faculties.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'code' => 'required|string|unique:faculties',
                'description' => 'nullable|string'
            ]);

        try {
            Faculty::create($validatedData);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.faculties.index')->with('success', 'Tworzenie wydziału powiodło się');
    }

    public function show(Faculty $faculty)
    {
        return view('modules.administrator.faculties.show', ['faculty' => $faculty]);
    }

    public function edit(Faculty $faculty)
    {
        return view('modules.administrator.faculties.edit', ['faculty' => $faculty]);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'code' => 'required|string|unique:faculties,code,' . $faculty->id,
                'description' => 'nullable|string'

            ]);

        try {
            $faculty->update($validatedData);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.faculties.index')->with('success', 'Aktualizacja wydziału powiodła się');
    }

    public function destroy(Faculty $faculty)
    {
        try {
            if (!$faculty->delete()) {
                throw new Exception("Usuwanie wydziału $faculty nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.faculties.index')->with('success', "Usuwanie wydziału $faculty powiodło się.");

    }
}
