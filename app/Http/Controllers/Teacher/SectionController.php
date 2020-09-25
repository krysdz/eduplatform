<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Group;
use App\Models\Section;
use App\Models\SectionFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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

        DB::beginTransaction();
        try {
            $section = Section::create(array_merge($validatedData, ['group_id' => $groupId]));

            if ($request->file('section_files')) {
                $validatedFiles = $request->validate([
                    'section_files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
                ]);

                foreach ($validatedFiles['section_files'] as $sectionFile) {
                    $filename = $sectionFile->getClientOriginalName();
                    $createdFile =File::create([
                        'name' => $filename,
                        'extension' => $sectionFile->getClientOriginalExtension(),
                        'path' =>  $sectionFile->storeAs('files/group_' . $groupId . '/section_' . $section->id, $filename, 'local'),
                        'mine_type' => $sectionFile->getClientMimeType(),
                        'size' => $sectionFile->getSize(),
                        'user_id' => $request->user()->id,
                    ]);

                    SectionFile::create([
                        'file_id' => $createdFile->id,
                        'section_id' => $section->id
                    ]);
                }
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            flash('Tworzenie sekcji nie powiodło się')->error();
            return redirect()->route('teacher.groups.sections.index', $groupId);
        }

        flash('Tworzenie sekcji powiodło się')->success();
        return redirect()->route('teacher.groups.sections.index', $groupId);
    }

    public function show(int $sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $files = Storage::disk('local')->allFiles('files/group_' . $section->group_id . '/section_' . $sectionId);
        $fileNames = [];

        foreach ($files as $file) {
            array_push($fileNames, basename($file));
        }

        return view('teacher.sections.show', [
            'section' => $section,
            'files' => $fileNames,
        ]);
    }

    public function edit(int $sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $files = Storage::disk('local')->allFiles('files/group_' . $section->group_id . '/section_' . $sectionId);
        $fileNames = [];

        foreach ($files as $file) {
            array_push($fileNames, basename($file));
        }

        return view('teacher.sections.edit', [
            'section' => $section,
            'files' => $fileNames,
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

        DB::beginTransaction();
        try {
            $currentSection->update($validatedData);
            if ($request->file('section_files')) {
                $validatedFiles = $request->validate([
                    'section_files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
                ]);

                foreach ($validatedFiles['section_files'] as $sectionFile) {
                    $filename = $sectionFile->getClientOriginalName();
                    $createdFile = File::create([
                        'name' => $filename,
                        'extension' => $sectionFile->getClientOriginalExtension(),
                        'path' =>  $sectionFile->storeAs('files/group_' . $currentSection->group_id . '/section_' . $sectionId, $filename, 'local'),
                        'mine_type' => $sectionFile->getClientMimeType(),
                        'size' => $sectionFile->getSize(),
                        'user_id' => $request->user()->id,
                    ]);

                    SectionFile::create([
                        'file_id' => $createdFile->id,
                        'section_id' => $currentSection->id
                    ]);
                }
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            flash('Aktualizacja sekcji nie powiodła się')->error();
            return redirect()->route('teacher.groups.sections.index', $currentSection->group_id);
        }

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
