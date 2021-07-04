<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleType;
use App\Http\Controllers\Controller;
use App\Mail\InitialAccess;
use App\Models\User;
use App\Models\UserRole;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('last_name')->orderBy('first_name')->get();

        return view('modules.administrator.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $userRoles = Auth::user()->roles->pluck('type.value')->all();

        if (in_array(UserRoleType::SuperAdministrator, $userRoles)) {
            $userRoleType = UserRoleType::asArray();
        } else {
            $userRoleType = UserRoleType::asArrayWithoutSuper();
        }

        return view('modules.administrator.users.create', [
            'userRoleType' => $userRoleType,
        ]);
    }

    public function store()
    {
        $validatedData = $this->validateData();

        DB::beginTransaction();

        try {
            if (in_array(UserRoleType::SuperAdministrator, $validatedData['roles'])) {
                $userRoles = Auth::user()->roles->pluck('type.value')->all();

                if (!in_array(UserRoleType::SuperAdministrator, $userRoles)) {
                    throw new Exception("Brak uprawnień do stworzenia SuperAdministratora");
                }
            }

            if(is_null($validatedData['password'])) {
                $password = substr(md5(random_int(PHP_INT_MIN, PHP_INT_MAX)), 0, 8);
                $validatedData['password'] = Hash::make($password);
            } else {
                $password = $validatedData['password'];
            }

            $user = User::create($validatedData);

            $user->roles()->createMany(array_map(
                fn($role) => ['type' => $role],
                $validatedData['roles']
            ));

            Mail::to($user->email)->send(new InitialAccess($user, $password));

            DB::commit();
            return redirect()->route('administrator.users.index')->with('success', 'Dodano użytkownika.');

        } catch (Throwable $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(User $user)
    {
        return view('modules.administrator.users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        $userRoles = Auth::user()->roles->pluck('type.value')->all();

        if (in_array(UserRoleType::SuperAdministrator, $userRoles)) {
            $userRoleType = UserRoleType::asArray();
        } else {
            $userRoleType = UserRoleType::asArrayWithoutSuper();
        }

        return view('modules.administrator.users.edit', [
            'user' => $user,
            'userRoleType' => $userRoleType,
        ]);
    }

    public function update(User $user)
    {
        $validatedData = $this->validateData($user);

        DB::beginTransaction();

        try {
            if (in_array(UserRoleType::SuperAdministrator, $validatedData['roles'])) {
                $userRoles = Auth::user()->roles->pluck('type.value')->all();

                if (!in_array(UserRoleType::SuperAdministrator, $userRoles)) {
                    throw new Exception("Brak uprawnień do stworzenia SuperAdministratora");
                }
            }

            $user->update($validatedData);

            $currentRoles = $user->roles->pluck('type.value')->all();

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

            return redirect()->route('administrator.users.index')->with('success', 'Aktualizacja użytkownika powiodła się.');

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

        return redirect()->route('administrator.users.index')->with('success', "Usuwanie użytkownika $user powiodło się.");
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
                'password' => 'nullable',
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
