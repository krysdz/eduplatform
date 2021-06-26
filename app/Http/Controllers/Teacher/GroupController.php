<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\GroupMemberType;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Term;
use Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $activeTerm = Term::getActiveTerm();
        $groups = null;

        if ($activeTerm) {
            $groups = Group::join('group_members', 'groups.id', '=', 'group_members.group_id')
                ->select('groups.*')
                ->where(['groups.term_id' => $activeTerm->id])
                ->where(['group_members.user_id' => Auth::id()])
                ->where(['group_members.type' => GroupMemberType::Teacher])
                ->get();
        }

        return view('teacher.groups.index', [
            'groups' => $groups,
        ]);
    }

    public function show(Group $group)
    {
        return view('teacher.groups.show', [
            'group' => $group
        ]);
    }
}
