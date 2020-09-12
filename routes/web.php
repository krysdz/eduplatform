<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index']);
});

Route::prefix('nauczyciel')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\IndexController::class, 'index']);
});

Route::prefix('student')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\IndexController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
