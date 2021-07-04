<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Throwable;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('shared.profile.index', [
            'user' => $user,
        ]);
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|current_password:web',
            'new_password' => ['required', 'string', Password::min( 8 )->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'new_password2' => 'required|string|same:new_password',
        ]);

        try {
            Auth::user()->update(['password' => \Hash::make($validatedData['new_password'])]);

        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('profile.index')->with('success', 'Zmiana hasła powiodła się.');
    }
}
