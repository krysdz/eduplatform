<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        if (!in_array($type, ['administrator', 'nauczyciel', 'student'])) {
            return redirect()->route('admin.users');
        }
        return view('admin.users.create', ['type' => $type]);
    }

    public function store(Request $request)
    {
        $type = $request->input('type');

        $validatedData = $this->validateData($type);

        if (!$validatedData) {
            return redirect()->route('admin.users');
        }

        DB::beginTransaction();

        try {

            $user = User::create($validatedData);

            switch ($type) {
                case 'administrator':
                    $user->admin()->create();
                    break;
                case 'nauczyciel':
                    $user->teacher()->create([
                        'website' => $validatedData['website'],
                        'degree' => $validatedData['degree']
                    ]);
                    break;
                case 'student':
                    $user->student()->create([
                        'code' => $validatedData['code'],
                    ]);
                    break;
            }

            DB::commit();

            return redirect()->route('admin.users');

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('admin.users');
        }


    }

    public function show(Request $request, int $id)
    {
        return view('admin.users.show', ['user' => User::findOrFail($id)]);
    }

    public function edit(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $this->validateData($user->type, $user);

        if (!$validatedData) {
            return redirect()->route('admin.users');
        }

        DB::beginTransaction();

        try {

            $user->update($validatedData);

            switch ($user->type) {
                case 'admin':
                    $user->admin()->update([]);
                    break;
                case 'teacher':
                    $user->teacher()->update([
                        'website' => $validatedData['website'],
                        'degree' => $validatedData['degree']
                    ]);
                    break;
                case 'student':
                    $user->student()->update([
                        'code' => $validatedData['code'],
                    ]);
                    break;
            }

            DB::commit();

            return redirect()->route('admin.users');

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('admin.users');
        }
    }

    public function destroy(Request $request, int $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users');
    }

    private function validateData(string $type, ?User $updatedUser = null): ?array
    {
        $validators = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:users",
            'phone' => 'nullable',
        ];

        if (!$updatedUser) {
            $validators = array_merge($validators, [
                'password' => 'required',
                'type' => 'required',
            ]);
        } else {
            $validators = array_merge($validators, [
                'email' => "required|email|unique:users,email,$updatedUser->id",
            ]);
        }

        switch ($type) {
            case 'administrator':
            case 'admin':
                request()->merge(['type' => 'admin']);
                $validators = array_merge($validators, []);
                break;
            case 'nauczyciel':
            case 'teacher':
                request()->merge(['type' => 'teacher']);
                $validators = array_merge($validators, [
                    'website' => 'nullable',
                    'degree' => 'required'
                ]);
                break;
            case 'student':
                request()->merge(['type' => 'student']);
                $validators = array_merge($validators, [
                    'code' => 'required|unique:students'
                ]);
                break;
            default:
                return null;
        }

        return request()->validate($validators);
    }
}
