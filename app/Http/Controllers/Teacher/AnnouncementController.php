<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\AnnouncementTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
    public function index(int $groupId)
    {
        return view('teacher.announcements.index', [
            'group' => Group::findOrFail($groupId),
            'announcements' => Announcement::where(['group_id' => $groupId])->get(),
        ]);
    }

    public function create(int $groupId)
    {
        return view('teacher.announcements.create', [
            'group' => Group::findOrFail($groupId),
            'types' => AnnouncementTypeEnum::toArray()
        ]);
    }

    public function store(Request $request, int $groupId)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required|integer'
        ]);
        $deadline = $validatedData['date'].' '.$validatedData['time'];
        $validatedData['type'] = AnnouncementTypeEnum::makeFromId($validatedData['type']);

        Announcement::create(array_merge($validatedData, ['group_id' => $groupId, 'deadline' => $deadline]));
        flash('Tworzenie ogloszenia powiodło się')->success();
        return redirect()->route('teacher.groups.announcements.index', $groupId);
    }

    public function show(int $announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        return view('teacher.announcements.show', [
            'group' => $announcement->group,
            'announcement' => $announcement,
        ]);
    }

    public function edit(int $announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        return view('teacher.announcements.edit', [
            'group' => $announcement->group,
            'announcement' => $announcement,
            'types' => AnnouncementTypeEnum::toArray()
        ]);
    }

    public function update(Request $request, int $announcementId)
    {
        $currentAnnouncement = Announcement::findOrFail($announcementId);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required|integer'
        ]);
        $deadline = $validatedData['date'].' '.$validatedData['time'];
        $validatedData['type'] = AnnouncementTypeEnum::makeFromId($validatedData['type']);

        $currentAnnouncement->update(array_merge($validatedData, ['deadline' => $deadline]));
        flash('Aktualizacja ogłoszenia powiodła się')->success();
        return redirect()->route('teacher.groups.announcements.index', $currentAnnouncement->group_id);
    }

    public function destroy(int $announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        $announcement->delete();
        flash('Usuwanie ogłoszenia powiodło się')->success();
        return redirect()->back();
    }
}
