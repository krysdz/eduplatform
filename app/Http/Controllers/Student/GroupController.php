<?php

namespace App\Http\Controllers\Student;

use App\Enums\GroupMemberType;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Auth::user()->groups()->withPivot('type')->where(['group_members.type' => GroupMemberType::Student])->get();

        return view('modules.student.groups.index', [
            'groups' => $groups,
        ]);
    }

    public function show(Group $group)
    {
        return view('modules.student.groups.show', [
            'group' => $group,
            'announcements' => $group->announcements,
            'sections' => $group->sections->whereNotNull('published_at')->sortBy('order', SORT_NATURAL),
        ]);
    }

}
