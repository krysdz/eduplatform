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
Route::get('/logout', function (){
    Auth::logout();
    return redirect()->route('index');
});

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
