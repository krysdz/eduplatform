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

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('index');
})->name('logout');

Route::middleware(['auth:sanctum', 'administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

    Route::prefix('uzytkownicy')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
        Route::get('/{id}/edytuj', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{id}/', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{id}/usun', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('semestry')->name('terms.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TermController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\TermController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\TermController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Admin\TermController::class, 'show'])->name('show');
        Route::get('/{id}/edytuj', [\App\Http\Controllers\Admin\TermController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\TermController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\TermController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('wydziały')->name('faculties.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\FacultyController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\FacultyController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\FacultyController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Admin\FacultyController::class, 'show'])->name('show');
        Route::get('/{id}/edytuj', [\App\Http\Controllers\Admin\FacultyController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\FacultyController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\FacultyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kursy')->name('courses.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CourseController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'show'])->name('show');
        Route::get('/{id}/edytuj', [\App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('grupy')->name('groups.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\GroupController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\GroupController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Admin\GroupController::class, 'show'])->name('show');
        Route::get('/{id}/edytuj', [\App\Http\Controllers\Admin\GroupController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\GroupController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth:sanctum', 'teacher'])->prefix('nauczyciel')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\IndexController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'student'])->prefix('student')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\IndexController::class, 'index']);
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

//Route::fallback(function () {
//    return '404';
//});
