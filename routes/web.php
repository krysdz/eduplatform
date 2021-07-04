<?php

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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('profil')->name('profile.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProfileController::class, 'index'])->name('index');
    Route::put('/', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('changePassword');
});

Route::middleware(['auth', 'can:Administrator'])->prefix('admin')->name('administrator.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

    Route::prefix('uzytkownicy')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
        Route::get('/{user}/edytuj', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}/', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}/usun', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('semestry')->name('terms.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TermController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\TermController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\TermController::class, 'store'])->name('store');
        Route::get('/{term}', [\App\Http\Controllers\Admin\TermController::class, 'show'])->name('show');
        Route::get('/{term}/edytuj', [\App\Http\Controllers\Admin\TermController::class, 'edit'])->name('edit');
        Route::put('/{term}', [\App\Http\Controllers\Admin\TermController::class, 'update'])->name('update');
        Route::delete('/{term}', [\App\Http\Controllers\Admin\TermController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('wydzialy')->name('faculties.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\FacultyController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\FacultyController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\FacultyController::class, 'store'])->name('store');
        Route::get('/{faculty}', [\App\Http\Controllers\Admin\FacultyController::class, 'show'])->name('show');
        Route::get('/{faculty}/edytuj', [\App\Http\Controllers\Admin\FacultyController::class, 'edit'])->name('edit');
        Route::put('/{faculty}', [\App\Http\Controllers\Admin\FacultyController::class, 'update'])->name('update');
        Route::delete('/{faculty}', [\App\Http\Controllers\Admin\FacultyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kursy')->name('courses.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CourseController::class, 'store'])->name('store');
        Route::get('/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'show'])->name('show');
        Route::get('/{course}/edytuj', [\App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('grupy')->name('groups.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\GroupController::class, 'index'])->name('index');
        Route::get('/dodaj', [\App\Http\Controllers\Admin\GroupController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('store');
        Route::get('/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'show'])->name('show');
        Route::get('/{group}/edytuj', [\App\Http\Controllers\Admin\GroupController::class, 'edit'])->name('edit');
        Route::put('/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'update'])->name('update');
        Route::delete('/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('destroy');

        Route::get('/{group}/harmonogramy', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'index'])->name('group_schedules.index');
        Route::get('/{group}/harmonogramy/dodaj', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'create'])->name('group_schedules.create');
        Route::post('/{group}/harmonogramy', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'store'])->name('group_schedules.store');
        Route::get('/{group}/harmonogramy/{groupSchedule}', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'show'])->name('group_schedules.show');
        Route::get('/{group}/harmonogramy/{groupSchedule}/edytuj', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'edit'])->name('group_schedules.edit');
        Route::put('/{group}/harmonogramy/{groupSchedule}', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'update'])->name('group_schedules.update');
        Route::delete('/{group}/harmonogramy/{groupSchedule}', [\App\Http\Controllers\Admin\GroupScheduleController::class, 'destroy'])->name('group_schedules.destroy');

        Route::get('/{group}/planowaneLekcje/', [\App\Http\Controllers\Admin\ScheduledLessonController::class, 'index'])->name('scheduled_lessons.index');
        Route::post('/{group}/planowaneLekcje/generuj', [\App\Http\Controllers\Admin\ScheduledLessonController::class, 'generate'])->name('scheduled_lessons.generate');
    });
});

Route::middleware(['auth', 'can:Teacher'])->prefix('nauczyciel')->name('teacher.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Teacher\IndexController::class, 'index'])->name('index');
    Route::get('/planZajec', [\App\Http\Controllers\Teacher\TimetableController::class, 'index'])->name('timetable.index');

    Route::prefix('grupy')->name('groups.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Teacher\GroupController::class, 'index'])->name('index');

        Route::middleware(['can.access.group:' . \App\Enums\UserRoleType::Teacher])->group(function () {
            Route::get('/{group}', [\App\Http\Controllers\Teacher\GroupController::class, 'show'])->name('show');

            Route::get('/{group}/lekcje', [\App\Http\Controllers\Teacher\LessonController::class, 'index'])->name('lessons.index');
            Route::get('/{group}/lekcje/dodaj', [\App\Http\Controllers\Teacher\LessonController::class, 'create'])->name('lessons.create');
            Route::post('/{group}/lekcje', [\App\Http\Controllers\Teacher\LessonController::class, 'store'])->name('lessons.store');
            Route::get('/{group}/lekcje/{lesson}', [\App\Http\Controllers\Teacher\LessonController::class, 'show'])->name('lessons.show');
            Route::get('/{group}/lekcje/{lesson}/edytuj', [\App\Http\Controllers\Teacher\LessonController::class, 'edit'])->name('lessons.edit');
            Route::put('/{group}/lekcje/{lesson}', [\App\Http\Controllers\Teacher\LessonController::class, 'update'])->name('lessons.update');

            Route::get('/{group}/sekcje', [\App\Http\Controllers\Teacher\SectionController::class, 'index'])->name('sections.index');
            Route::get('/{group}/sekcje/dodaj', [\App\Http\Controllers\Teacher\SectionController::class, 'create'])->name('sections.create');
            Route::post('/{group}/sekcje', [\App\Http\Controllers\Teacher\SectionController::class, 'store'])->name('sections.store');
            Route::get('/{group}/sekcje/{section}', [\App\Http\Controllers\Teacher\SectionController::class, 'show'])->name('sections.show');
            Route::get('/{group}/sekcje/{section}/edytuj', [\App\Http\Controllers\Teacher\SectionController::class, 'edit'])->name('sections.edit');
            Route::put('/{group}/sekcje/{section}', [\App\Http\Controllers\Teacher\SectionController::class, 'update'])->name('sections.update');
            Route::delete('/{group}/sekcje/{section}', [\App\Http\Controllers\Teacher\SectionController::class, 'destroy'])->name('sections.destroy');

            Route::get('/{group}/ogloszenia', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'index'])->name('announcements.index');
            Route::get('/{group}/ogloszenia/dodaj', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'create'])->name('announcements.create');
            Route::post('/{group}/ogloszenia', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'store'])->name('announcements.store');
            Route::get('/{group}/ogloszenia/{announcement}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'show'])->name('announcements.show');
            Route::get('/{group}/ogloszenia/{announcement}/edytuj', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'edit'])->name('announcements.edit');
            Route::put('/{group}/ogloszenia/{announcement}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'update'])->name('announcements.update');
            Route::delete('/{group}/ogloszenia/{announcement}', [\App\Http\Controllers\Teacher\AnnouncementController::class, 'destroy'])->name('announcements.destroy');

            Route::get('/{group}/frekwencja', [\App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('attendances.index');
            Route::get('/{group}/frekwencja/edytuj', [\App\Http\Controllers\Teacher\AttendanceController::class, 'edit'])->name('attendances.edit');
            Route::put('/{group}/frekwencja', [\App\Http\Controllers\Teacher\AttendanceController::class, 'update'])->name('attendances.update');

            Route::get('/{group}/oceny', [\App\Http\Controllers\Teacher\GradeController::class, 'index'])->name('grades.index');
            Route::get('/{group}/oceny/dodaj', [\App\Http\Controllers\Teacher\GradeController::class, 'create'])->name('grades.create');
            Route::post('/{group}/oceny', [\App\Http\Controllers\Teacher\GradeController::class, 'store'])->name('grades.store');
            Route::get('/{group}/oceny/{gradeItem}/edytuj', [\App\Http\Controllers\Teacher\GradeController::class, 'edit'])->name('grades.edit');
            Route::put('/{group}/oceny/{gradeItem}', [\App\Http\Controllers\Teacher\GradeController::class, 'update'])->name('grades.update');
            Route::delete('/{group}/oceny/{gradeItem}', [\App\Http\Controllers\Teacher\GradeController::class, 'destroy'])->name('grades.destroy');
        });
    });
});

Route::middleware(['auth', 'can:Student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\IndexController::class, 'index'])->name('index');

    Route::get('/planZajec', [\App\Http\Controllers\Student\TimetableController::class, 'index'])->name('timetable.index');

    Route::get('/grupy', [\App\Http\Controllers\Student\GroupController::class, 'index'])->name('group.index');

    Route::middleware(['can.access.group:' . \App\Enums\UserRoleType::Student])->group(function () {
        Route::get('/grupy/{group}', [\App\Http\Controllers\Student\GroupController::class, 'show'])->name('group.show');
    });

    Route::get('/oceny', [\App\Http\Controllers\Student\GradeController::class, 'index'])->name('grade.index');

    Route::get('/frekwencja', [\App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendances.index');
});

Route::middleware(['auth'])->prefix('wiadomosci')->name('messenger.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Messenger\ThreadController::class, 'index'])->name('index');
    Route::get('/nowa', [\App\Http\Controllers\Messenger\ThreadController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Messenger\ThreadController::class, 'store'])->name('store');
    Route::get('/{thread}', [\App\Http\Controllers\Messenger\ThreadController::class, 'show'])->name('show');
    Route::post('/{thread}', [\App\Http\Controllers\Messenger\ThreadController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->prefix('pliki')->name('file.')->group(function () {
    Route::get('/{file}/{fileName}', [\App\Http\Controllers\FileController::class, 'show'])->name('show');
    Route::delete('/{file}', [\App\Http\Controllers\FileController::class, 'destroy'])->name('destroy');
});
