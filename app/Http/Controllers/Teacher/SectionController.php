<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Section;
use App\Service\FileService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SectionController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Group $group)
    {
        return view('modules.teacher.sections.index', [
            'sections' => Section::where(['group_id' => $group->id])->orderBy('order')->get(),
            'group' => $group,
        ]);
    }

    public function create(Group $group)
    {
        return view('modules.teacher.sections.create', [
            'group' => $group,
            'lessons' => Lesson::whereHas('scheduledLesson', function (Builder $q) use ($group) {
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
            $section = Section::create(
                array_merge($validatedData, ['group_id' => $group->id])
            );
            $this->fileService->handleRequestSectionFiles($request, $section);

            DB::commit();

            return redirect()->route('teacher.groups.sections.index', $group)
                ->with('success', 'Sekcja została dodana.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Group $group, Section $section)
    {
        return view('modules.teacher.sections.show', [
            'section' => $section,
            'group' => $group,
        ]);
    }

    public function edit(Group $group, Section $section)
    {
        return view('modules.teacher.sections.edit', [
            'section' => $section,
            'group' => $group,
            'lessons' => Lesson::whereHas('scheduledLesson', function (Builder $q) use ($group) {
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
            $this->fileService->handleRequestSectionFiles($request, $section);

            DB::commit();
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('teacher.groups.sections.index', $group)
            ->with('success', 'Sekcja została zaktualizaowana.');
    }

    public function destroy(Group $group, Section $section)
    {
        try {
            if (!$section->delete()) {
                throw new Exception("Usuwanie sekcji $section nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('teacher.groups.sections.index', $group)
            ->with('success', "Sekcja \"$section\" została usunięta.");
    }
}
