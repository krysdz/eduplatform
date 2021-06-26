<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleType;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            return view('index');
        }

        $roles = Auth::user()->roles->pluck('type.value')->all();
        $hasOnlyOneRole = 1 === count($roles);

        if ($hasOnlyOneRole) {
            $routePrefix = strtolower(UserRoleType::fromValue($roles[0])->key);
            return redirect()->route($routePrefix . '.index');
        }

        return view('index', [
            'roles' => $roles,
        ]);
    }
}
