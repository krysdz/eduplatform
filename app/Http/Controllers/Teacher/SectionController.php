<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(int $groupId)
    {
        return view('teacher.sections.index', [
            'sections' => Section::where(['group_id' => $groupId])->get(),
            'group' => Group::findOrFail($groupId),
        ]);
    }

    public function create(int $groupId)
    {
        return view('teacher.sections.create', [
            'group' => Group::findOrFail($groupId),
        ]);
    }


    public function store(Request $request, int $groupId)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'position' => 'nullable|integer',
            'is_active' => 'sometimes|string'
        ]);
        $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');

        Section::create(array_merge($validatedData, ['group_id' => $groupId]));
        flash('Tworzenie sekcji powiodło się')->success();
        return redirect()->route('teacher.groups.sections.index', $groupId);
    }

    public function show(int $sectionId)
    {
        return view('teacher.sections.show', [
            'section' => Section::findOrFail($sectionId)
        ]);
    }


    public function edit(int $sectionId)
    {
        return view('teacher.sections.edit', [
            'section' => Section::findOrFail($sectionId)
        ]);
    }

    public function update(Request $request, int $sectionId)
    {
        $currentSection = Section::findOrFail($sectionId);
        $action = $request->input('action');
        $validatedData = [];

        switch ($action) {
            case 'publish':
                $validatedData['is_active'] = true;
                break;
            case 'hide':
                $validatedData['is_active'] = false;
                break;
            default:
                $validatedData = $request->validate([
                    'title' => 'required|string',
                    'description' => 'nullable|string',
                    'position' => 'nullable|integer',
                    'is_active' => 'sometimes|string'
                ]);
                $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');
                break;
        }

        $currentSection->update($validatedData);
        flash('Aktualizacja sekcji powiodło się')->success();
        return redirect()->route('teacher.groups.sections.index', $currentSection->group_id);
    }

    public function destroy($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        if (!empty($section->lesson_id)) {
            flash('Nie możesz usunąć sekcji stworzonej na podstawie lekcji')->error();
            return redirect()->route('teacher.groups.sections.index', $section->group_id);
        }
        if (!$section->delete()) {
            flash('Usuwanie sekcji nie powiodło się')->error();
        }

        flash('Usuwanie sekcji powiodło się')->success();
        return redirect()->route('teacher.groups.sections.index', $section->group_id);
    }
}
