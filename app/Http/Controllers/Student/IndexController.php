<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
//        dd(request()->user()->notifications());
        return view('student.index', [
            'notifications' => auth()->user()->notifications,
        ]);
    }

}
