<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.index', [
            'lastUpdatedUsers' => User::orderBy('updated_at')->limit(5)->get(),
        ]);
    }
}
