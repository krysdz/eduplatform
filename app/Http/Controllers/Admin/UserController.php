<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $userRoleType = UserRoleType::asArrayWithoutSuper();

        return view('admin.users.create', [
            'userRoleType' => $userRoleType,
        ]);
    }

    public function store()
    {
        $validatedData = $this->validateData();

        DB::beginTransaction();

        try {
            $user = User::create($validatedData);

            $user->roles()->createMany(array_map(
                fn($role) => ['type' => $role],
                $validatedData['roles']
            ));

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Dodano użytkownika.');

        } catch (Throwable $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        $userRoleType = UserRoleType::asArrayWithoutSuper();

        return view('admin.users.edit', [
            'user' => $user,
            'userRoleType' => $userRoleType,
        ]);
    }

    public function update(User $user)
    {
        $validatedData = $this->validateData($user);

        DB::beginTransaction();

        try {
            $user->update($validatedData);

            $currentRoles = $user->roles->pluck('type.value')->all();

            if (($key = array_search(UserRoleType::SuperAdministrator, $currentRoles)) !== false) {
                unset($currentRoles[$key]);
            }

            $removeRoles = array_diff($currentRoles, $validatedData['roles']);
            $insertRoles = array_diff($validatedData['roles'], $currentRoles);

            foreach ($removeRoles as $role) {
                UserRole::where([
                    'user_id' => $user->id,
                    'type' => $role
                ])->delete();
            }

            $user->roles()->createMany(array_map(
                fn($role) => ['type' => $role],
                $insertRoles
            ));

            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'Aktualizacja użytkownika powiodła się.');

        } catch (Throwable $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            if (!$user->delete()) {
                throw new Exception("Usuwanie użytkownika $user nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('admin.users.index')->with('success', "Usuwanie użytkownika $user powiodło się.");
    }

    private function validateData(?User $updatedUser = null): ?array
    {
        $validators = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'website' => 'nullable',
            'degree' => 'nullable',
            'code' => 'nullable|unique:users',
            'roles' => 'required',
        ];

        if (!$updatedUser) {
            $validators = array_merge($validators, [
                'password' => 'required',
            ]);
        } else {
            $validators = array_merge($validators, [
                'email' => "required|email|unique:users,email,$updatedUser->id",
                'code' => "nullable|unique:users,code,$updatedUser->id",
            ]);
        }

        return request()->validate($validators);
    }
}
