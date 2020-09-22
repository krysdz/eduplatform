<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $archived = $request->query('archived') === "true";

        return view('teacher.groups.index', [
            'groups' => Group::whereHas('term', function (Builder $q) use ($archived) {
                $q->where(['is_active' => !$archived]);
            })->where(['teacher_id' => $request->user()->teacher->id])->get(),
            'archived' => $archived
        ]);
    }

    public function show(int $groupId)
    {
        return view('teacher.groups.show', [
            'group' => Group::findOrFail($groupId)
        ]);
    }
}
