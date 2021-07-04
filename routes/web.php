<?php

use App\Enums\UserRoleType;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Messenger\ThreadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\FacultyController as AdminFacultyController;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\Admin\GroupScheduleController as AdminGroupScheduleController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\ScheduledLessonController as AdminScheduledLessonController;
use App\Http\Controllers\Admin\TermController as AdminTermController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Student\GroupController as StudentGroupController;
use App\Http\Controllers\Student\IndexController as StudentIndexController;
use App\Http\Controllers\Student\TimetableController as StudentTimetableController;
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncementController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\GradeController as TeacherGradeController;
use App\Http\Controllers\Teacher\GroupController as TeacherGroupController;
use App\Http\Controllers\Teacher\IndexController as TeacherIndexController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;
use App\Http\Controllers\Teacher\SectionController as TeacherSectionController;
use App\Http\Controllers\Teacher\TimetableController as TeacherTimetableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/logowanie', [AuthController::class, 'login'])->name('login');
Route::post('/logowanie', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/wyloguj', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('profil')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/zmiana-hasla', [ProfileController::class, 'changePassword'])->name('change_password');
    });

    Route::prefix('wiadomosci')->name('messenger.')->group(function () {
        Route::get('/', [ThreadController::class, 'index'])->name('index');
        Route::get('/nowa', [ThreadController::class, 'create'])->name('create');
        Route::post('/', [ThreadController::class, 'store'])->name('store');
        Route::get('/{thread}', [ThreadController::class, 'show'])->name('show');
        Route::post('/{thread}', [ThreadController::class, 'sendMessage'])->name('send_message');
    });

    Route::prefix('pliki')->name('file.')->group(function () {
        Route::get('/{file}/{file_name}', [FileController::class, 'show'])->name('show');
        Route::delete('/{file}', [FileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('administrator')->middleware(['can:administrator'])->name('administrator.')->group(function () {
        Route::get('/', [AdminIndexController::class, 'index'])->name('index');

        Route::prefix('uzytkownicy')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/dodaj', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
            Route::get('/{user}/edytuj', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('semestry')->name('terms.')->group(function () {
            Route::get('/', [AdminTermController::class, 'index'])->name('index');
            Route::get('/dodaj', [AdminTermController::class, 'create'])->name('create');
            Route::post('/', [AdminTermController::class, 'store'])->name('store');
            Route::get('/{term}', [AdminTermController::class, 'show'])->name('show');
            Route::get('/{term}/edytuj', [AdminTermController::class, 'edit'])->name('edit');
            Route::put('/{term}', [AdminTermController::class, 'update'])->name('update');
            Route::delete('/{term}', [AdminTermController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('wydzialy')->name('faculties.')->group(function () {
            Route::get('/', [AdminFacultyController::class, 'index'])->name('index');
            Route::get('/dodaj', [AdminFacultyController::class, 'create'])->name('create');
            Route::post('/', [AdminFacultyController::class, 'store'])->name('store');
            Route::get('/{faculty}', [AdminFacultyController::class, 'show'])->name('show');
            Route::get('/{faculty}/edytuj', [AdminFacultyController::class, 'edit'])->name('edit');
            Route::put('/{faculty}', [AdminFacultyController::class, 'update'])->name('update');
            Route::delete('/{faculty}', [AdminFacultyController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('kursy')->name('courses.')->group(function () {
            Route::get('/', [AdminCourseController::class, 'index'])->name('index');
            Route::get('/dodaj', [AdminCourseController::class, 'create'])->name('create');
            Route::post('/', [AdminCourseController::class, 'store'])->name('store');
            Route::get('/{course}', [AdminCourseController::class, 'show'])->name('show');
            Route::get('/{course}/edytuj', [AdminCourseController::class, 'edit'])->name('edit');
            Route::put('/{course}', [AdminCourseController::class, 'update'])->name('update');
            Route::delete('/{course}', [AdminCourseController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('grupy')->name('groups.')->group(function () {
            Route::get('/', [AdminGroupController::class, 'index'])->name('index');
            Route::get('/dodaj', [AdminGroupController::class, 'create'])->name('create');
            Route::post('/', [AdminGroupController::class, 'store'])->name('store');
            Route::get('/{group}', [AdminGroupController::class, 'show'])->name('show');
            Route::get('/{group}/edytuj', [AdminGroupController::class, 'edit'])->name('edit');
            Route::put('/{group}', [AdminGroupController::class, 'update'])->name('update');
            Route::delete('/{group}', [AdminGroupController::class, 'destroy'])->name('destroy');

            Route::prefix('{group}/harmonogramy')->name('group_schedules.')->group(function () {
                Route::get('', [AdminGroupScheduleController::class, 'index'])->name('index');
                Route::get('/dodaj', [AdminGroupScheduleController::class, 'create'])->name('create');
                Route::post('/', [AdminGroupScheduleController::class, 'store'])->name('store');
                Route::get('/{group_schedule}', [AdminGroupScheduleController::class, 'show'])->name('show');
                Route::get('/{group_schedule}/edytuj', [AdminGroupScheduleController::class, 'edit'])->name('edit');
                Route::put('/{group_schedule}', [AdminGroupScheduleController::class, 'update'])->name('update');
                Route::delete('/{group_schedule}', [AdminGroupScheduleController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('{group}/planowane-lekcje')->name('scheduled_lessons.')->group(function () {
                Route::get('/', [AdminScheduledLessonController::class, 'index'])->name('index');
                Route::post('/generuj', [AdminScheduledLessonController::class, 'generate'])->name('generate');
            });
        });
    });

    Route::prefix('nauczyciel')->middleware(['can:teacher'])->name('teacher.')->group(function () {
        Route::get('/', [TeacherIndexController::class, 'index'])->name('index');
        Route::get('/plan-zajec', [TeacherTimetableController::class, 'index'])->name('timetable.index');
        Route::get('/grupy', [TeacherGroupController::class, 'index'])->name('groups.index');

        Route::prefix('grupy/{group}')
            ->middleware(['can.access.group:' . UserRoleType::Teacher])
            ->name('groups.')
            ->group(function () {
                Route::get('/', [TeacherGroupController::class, 'show'])->name('show');

                Route::prefix('lekcje')->name('lessons.')->group(function () {
                    Route::get('/', [TeacherLessonController::class, 'index'])->name('index');
                    Route::get('/dodaj', [TeacherLessonController::class, 'create'])->name('create');
                    Route::post('/', [TeacherLessonController::class, 'store'])->name('store');
                    Route::get('/{lesson}', [TeacherLessonController::class, 'show'])->name('show');
                    Route::get('/{lesson}/edytuj', [TeacherLessonController::class, 'edit'])->name('edit');
                    Route::put('/{lesson}', [TeacherLessonController::class, 'update'])->name('update');
                });

                Route::prefix('sekcje')->name('sections.')->group(function () {
                    Route::get('/', [TeacherSectionController::class, 'index'])->name('index');
                    Route::get('/dodaj', [TeacherSectionController::class, 'create'])->name('create');
                    Route::post('/', [TeacherSectionController::class, 'store'])->name('store');
                    Route::get('/{section}', [TeacherSectionController::class, 'show'])->name('show');
                    Route::get('/{section}/edytuj', [TeacherSectionController::class, 'edit'])->name('edit');
                    Route::put('/{section}', [TeacherSectionController::class, 'update'])->name('update');
                    Route::delete('/{section}', [TeacherSectionController::class, 'destroy'])->name('destroy');
                });

                Route::prefix('ogloszenia')->name('announcements.')->group(function () {
                    Route::get('/', [TeacherAnnouncementController::class, 'index'])->name('index');
                    Route::get('/dodaj', [TeacherAnnouncementController::class, 'create'])->name('create');
                    Route::post('/', [TeacherAnnouncementController::class, 'store'])->name('store');
                    Route::get('/{announcement}', [TeacherAnnouncementController::class, 'show'])->name('show');
                    Route::get('/{announcement}/edytuj', [TeacherAnnouncementController::class, 'edit'])->name('edit');
                    Route::put('/{announcement}', [TeacherAnnouncementController::class, 'update'])->name('update');
                    Route::delete('/{announcement}', [TeacherAnnouncementController::class, 'destroy'])
                        ->name('destroy');
                });

                Route::prefix('frekwencja')->name('attendances.')->group(function () {
                    Route::get('/', [TeacherAttendanceController::class, 'index'])->name('index');
                    Route::get('/edytuj', [TeacherAttendanceController::class, 'edit'])->name('edit');
                    Route::put('/', [TeacherAttendanceController::class, 'update'])->name('update');
                });

                Route::prefix('oceny')->name('grades.')->group(function () {
                    Route::get('/', [TeacherGradeController::class, 'index'])->name('index');
                    Route::get('/dodaj', [TeacherGradeController::class, 'create'])->name('create');
                    Route::post('/', [TeacherGradeController::class, 'store'])->name('store');
                    Route::get('/{grade_item}/edytuj', [TeacherGradeController::class, 'edit'])->name('edit');
                    Route::put('/{grade_item}', [TeacherGradeController::class, 'update'])->name('update');
                    Route::delete('/{grade_item}', [TeacherGradeController::class, 'destroy'])->name('destroy');
                });
            });
    });

    Route::prefix('student')->middleware(['can:student'])->name('student.')->group(function () {
        Route::get('/', [StudentIndexController::class, 'index'])->name('index');
        Route::get('/plan-zajec', [StudentTimetableController::class, 'index'])->name('timetable.index');
        Route::get('/oceny', [StudentGradeController::class, 'index'])->name('grades.index');
        Route::get('/frekwencja', [StudentAttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/grupy', [StudentGroupController::class, 'index'])->name('groups.index');

        Route::prefix('grupy/{group}')
            ->middleware(['can.access.group:' . UserRoleType::Student])
            ->name('groups.')
            ->group(function () {
                Route::get('/', [StudentGroupController::class, 'show'])->name('show');
            });
    });
});
