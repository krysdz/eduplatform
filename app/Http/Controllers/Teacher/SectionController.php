<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\SectionFile;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;


class SectionController extends Controller
{
    public function index(Group $group)
    {
        return view('teacher.sections.index', [
            'sections' => Section::where(['group_id' => $group->id])->orderBy('order')->get(),
            'group' => $group,
        ]);
    }

    public function create(Group $group)
    {
        return view('teacher.sections.create', [
            'group' => $group,
            'lessons' => Lesson::whereHas('scheduledLesson', function(Builder $q) use ($group) {
                $q->where('group_id', '=', $group->id);
            })->get(),
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'lesson_id' => 'nullable|integer|exists:lessons,id',
            'published_at' => 'nullable|date'
        ]);

        DB::beginTransaction();

        try {
            $section = Section::create(array_merge($validatedData, ['group_id' => $group->id]));

            if ($request->hasFile('section_files')) {
                $validatedFiles = $request->validate([
                    'section_files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
                ]);

                foreach ($validatedFiles['section_files'] as $sectionFile) {
                    $filename = $sectionFile->getClientOriginalName();
                    $createdFile = File::create([
                        'filename' => $filename,
                        'extension' => $sectionFile->getClientOriginalExtension(),
                        'path' =>  $sectionFile->storeAs('files/group_' . $group->id . '/section_' . $section->id, $filename, 'local'),
                        'mimetype' => $sectionFile->getClientMimeType(),
                        'size' => $sectionFile->getSize(),
                        'user_id' => $request->user()->id,
                    ]);

                    SectionFile::create([
                        'title' => $filename,
                        'file_id' => $createdFile->id,
                        'section_id' => $section->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('teacher.groups.sections.index', $group)->with('success', 'Tworzenie sekcji powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Group $group, Section $section)
    {
        return view('teacher.sections.show', [
            'section' => $section,
            'group' => $group,
        ]);
    }

    public function edit(Group $group, Section $section)
    {
        return view('teacher.sections.edit', [
            'section' => $section,
            'group' => $group,
            'lessons' => Lesson::whereHas('scheduledLesson', function(Builder $q) use ($group) {
                $q->where('group_id', '=', $group->id);
            })->get(),
        ]);
    }

    public function update(Request $request, Group $group, Section $section)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'lesson_id' => 'nullable|integer|exists:lessons,id',
            'published_at' => 'nullable|date'
        ]);

        DB::beginTransaction();

        try {
            $section->update($validatedData);
            if ($request->hasFile('section_files')) {
                $validatedFiles = $request->validate([
                    'section_files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
                ]);

                foreach ($validatedFiles['section_files'] as $sectionFile) {
                    $filename = $sectionFile->getClientOriginalName();
                    $createdFile = File::create([
                        'filename' => $filename,
                        'extension' => $sectionFile->getClientOriginalExtension(),
                        'path' => $sectionFile->storeAs('files/group_' . $section->group_id . '/section_' . $section, $filename, 'local'),
                        'mimetype' => $sectionFile->getClientMimeType(),
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

            return redirect()->route('teacher.groups.sections.index', $group)->with('success', 'Aktualizacja sekcji powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(Group $group, Section $section)
    {
        try {
            foreach ($section->sectionFiles as $sectionFile) {
                if(Storage::delete($sectionFile->file->path)) {
                    $sectionFile->file()->delete();
                }
                Storage::deleteDirectory('files/group_' . $group->id . '/section_' . $section->id);
            }

            if (!$section->delete()) {
                throw new Exception( "Usuwanie sekcji $section nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('teacher.groups.sections.index', $group)->with('success', "Usuwanie sekcji $section powiodło się.");
    }
}
