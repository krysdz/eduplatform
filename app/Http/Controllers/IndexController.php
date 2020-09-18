<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return '<h1>Internetowa platforma wspomagania nauczania</h1><button><a href="/login">Zaloguj</a></button>';
    }
}
