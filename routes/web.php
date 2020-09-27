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

Route::middleware(['auth:sanctum', 'teacher'])->prefix('nauczyciel')->name('teacher.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\IndexController::class, 'index'])->name('index');

    Route::prefix('grupy')->name('groups.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Teacher\GroupController::class, 'index'])->name('index');
        Route::get('/{groupId}', [\App\Http\Controllers\Teacher\GroupController::class, 'show'])->name('show');

        Route::get('/{groupId}/lekcje', [\App\Http\Controllers\Teacher\LessonController::class, 'index'])->name('lessons.index');

        Route::get('/{groupId}/sekcje', [\App\Http\Controllers\Teacher\SectionController::class, 'index'])->name('sections.index');
        Route::get('/{groupId}/sekcje/dodaj', [\App\Http\Controllers\Teacher\SectionController::class, 'create'])->name('sections.create');
        Route::post('/{groupId}/sekcje', [\App\Http\Controllers\Teacher\SectionController::class, 'store'])->name('sections.store');

        Route::get('/{groupId}/ogloszenia', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/{groupId}/ogloszenia/dodaj', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/{groupId}/ogloszenia', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'store'])->name('announcements.store');

        Route::get('/{groupId}/frekwencja', [\App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/{groupId}/frekwencja/dodaj', [\App\Http\Controllers\Teacher\AttendanceController::class, 'create'])->name('attendances.create');
        Route::put('/{groupId}/frekwencja', [\App\Http\Controllers\Teacher\AttendanceController::class, 'update'])->name('attendances.update');

        Route::get('/{groupId}/oceny', [\App\Http\Controllers\Teacher\GradeController::class, 'index'])->name('grades.index');
        Route::get('/{groupId}/oceny/dodaj', [\App\Http\Controllers\Teacher\GradeController::class, 'create'])->name('grades.create');
        Route::post('/{groupId}/oceny', [\App\Http\Controllers\Teacher\GradeController::class, 'store'])->name('grades.store');
    });

    Route::prefix('lekcje')->name('lessons.')->group(function () {
        Route::get('/{lessonId}', [\App\Http\Controllers\Teacher\LessonController::class, 'show'])->name('show');
        Route::get('/{lessonId}/edytuj', [\App\Http\Controllers\Teacher\LessonController::class, 'edit'])->name('edit');
        Route::put('/{lessonId}', [\App\Http\Controllers\Teacher\LessonController::class, 'update'])->name('update');
    });

    Route::prefix('sekcje')->name('sections.')->group(function () {
        Route::get('/{sectionId}', [\App\Http\Controllers\Teacher\SectionController::class, 'show'])->name('show');
        Route::get('/{sectionId}/edytuj', [\App\Http\Controllers\Teacher\SectionController::class, 'edit'])->name('edit');
        Route::put('/{sectionId}', [\App\Http\Controllers\Teacher\SectionController::class, 'update'])->name('update');
        Route::delete('/{sectionId}', [\App\Http\Controllers\Teacher\SectionController::class, 'destroy'])->name('destroy');

        Route::get('/{sectionId}/pliki/{fileId}/{fileName}', [\App\Http\Controllers\SectionFileController::class, 'show'])->name('files.show');
        Route::delete('/{sectionId}/pliki/{fileId}', [\App\Http\Controllers\SectionFileController::class, 'destroy'])->name('files.destroy');
    });

    Route::prefix('ogloszenia')->name('announcements.')->group(function () {
        Route::get('/{announcementId}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'show'])->name('show');
        Route::get('/{announcementId}/edytuj', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcementId}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcementId}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth:sanctum', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\IndexController::class, 'index'])->name('index');
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

//Route::fallback(function () {
//    return '404';
//});
