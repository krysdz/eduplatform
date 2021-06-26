<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleType;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return view('index');
        }

        $roles = Auth::user()->roles->pluck('type.value')->all();

        if (in_array(UserRoleType::SuperAdministrator, $roles)) {
            $roles[] = UserRoleType::Administrator;
        }

        $allowedRoles = array_values(UserRoleType::asArrayWithoutSuper());
        $roles = array_intersect($allowedRoles, $roles);

        if (1 === count($roles)) {
            $routePrefix = strtolower(UserRoleType::fromValue(array_values($roles)[0])->key);
            return redirect()->route($routePrefix . '.index');
        }

        return view('index', [
            'roles' => $roles,
        ]);
    }
}
