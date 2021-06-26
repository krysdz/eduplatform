<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $roles = [];

        if (Auth::user()) {
            $roles = Auth::user()->roles->pluck('type.value')->all();
        }

        return view('index', [
            'roles' => $roles,
        ]);
    }
}
