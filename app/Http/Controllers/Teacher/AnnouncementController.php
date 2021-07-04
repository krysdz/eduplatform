<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\AnnouncementType;
use App\Enums\UserRoleType;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Group;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class AnnouncementController extends Controller
{
    public function index(Group $group)
    {
        return view('modules.teacher.announcements.index', [
            'group' => $group,
            'announcements' => Announcement::where(['group_id' => $group->id])->get(),
        ]);
    }

    public function create(Group $group)
    {
        return view('modules.teacher.announcements.create', [
            'group' => $group,
            'types' => AnnouncementType::asArray()
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'type' => 'required|integer'
        ]);
        $markAt = $validatedData['date'].' '.$validatedData['time'];

        DB::beginTransaction();

        try {
            Announcement::create(array_merge($validatedData, ['group_id' => $group->id, 'mark_at' => $markAt]));
            DB::commit();

            return redirect()->route('teacher.groups.announcements.index', $group)->with('success', 'Tworzenie ogłoszenia powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Group $group, Announcement $announcement)
    {
        return view('modules.teacher.announcements.show', [
            'group' => $group,
            'announcement' => $announcement,
        ]);
    }

    public function edit(Group $group, Announcement $announcement)
    {
        return view('modules.teacher.announcements.edit', [
            'group' => $group,
            'announcement' => $announcement,
            'types' => AnnouncementType::asArray()
        ]);
    }

    public function update(Request $request, Group $group, Announcement $announcement)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'type' => 'required|integer'
        ]);

        $markAt = $validatedData['date'].' '.$validatedData['time'];

        DB::beginTransaction();

        try {
            $announcement->update(array_merge($validatedData, ['mark_at' => $markAt]));
            DB::commit();

            return redirect()->route('teacher.groups.announcements.index', $group)->with('success', 'Aktualizacja ogłoszenia powiodło się.');
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(Group $group, Announcement $announcement)
    {
        try {
            if (!$announcement->delete()) {
                throw new Exception("Usuwanie ogłoszenia $announcement nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('teacher.groups.announcements.index', $group)->with('success', "Usuwanie ogłoszenia $announcement powiodło się.");
    }
}
