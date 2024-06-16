<?php

use App\Http\Controllers\API\MasterData\ClassroomController;
use App\Http\Controllers\API\MasterData\Lesson\CurriculumLessonController;
use App\Http\Controllers\API\MasterData\Lesson\LessonCategoryController;
use App\Http\Controllers\API\MasterData\Lesson\LessonController;
use App\Http\Controllers\API\MasterData\Schedule\ScheduleDayController;
use App\Http\Controllers\API\MasterData\Schedule\ScheduleLessonHourController;
use App\Http\Controllers\API\MasterData\SemesterController;
use App\Http\Controllers\API\MasterData\User\RoleController;
use App\Http\Controllers\API\MasterData\User\UserController;
use App\Http\Controllers\API\MasterData\User\UserStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Role Access API
Route::prefix('role-access')->name('role-access.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
});

// Lesson API Routes
Route::prefix('lesson')->name('lesson.')->group(function () {
    Route::get('/', [LessonController::class, 'index'])->name('index');
    Route::post('/store', [LessonController::class, 'store'])->name('store');
    Route::get('/{id}', [LessonController::class, 'show'])->name('show');
    Route::put('/update/{id}', [LessonController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [LessonController::class, 'destroy'])->name('destroy');
});

// Lesson Category API Routes
Route::prefix('lesson-category')->name('lesson-category.')->group(function () {
    Route::get('/', [LessonCategoryController::class, 'index'])->name('index');
    Route::post('/store', [LessonCategoryController::class, 'store'])->name('store');
    Route::get('/{id}', [LessonCategoryController::class, 'show'])->name('show');
    Route::put('/update/{id}', [LessonCategoryController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [LessonCategoryController::class, 'destroy'])->name('destroy');
});

// Classroom API Routes
Route::prefix('classroom')->name('classroom.')->group(function () {
    Route::get('/', [ClassroomController::class, 'index'])->name('index');
    Route::post('/store', [ClassroomController::class, 'store'])->name('store');
    Route::get('/{id}', [ClassroomController::class, 'show'])->name('show');
    Route::put('/update/{id}', [ClassroomController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [ClassroomController::class, 'destroy'])->name('destroy');
});

// Classroom API Routes
Route::prefix('classroom-label')->name('classroom-label.')->group(function () {
    Route::get('/', [ClassroomController::class, 'getClassroomLabel'])->name('get-classroom-label');
});

// Semester API Routes
Route::prefix('semester')->name('semester.')->group(function () {
    Route::get('/', [SemesterController::class, 'index'])->name('index');
    Route::get('/active', [SemesterController::class, 'findActiveSemester'])->name('active-semester');
    Route::post('/store', [SemesterController::class, 'store'])->name('store');
    Route::get('/{id}', [SemesterController::class, 'show'])->name('show');
    Route::put('/update/{id}', [SemesterController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [SemesterController::class, 'destroy'])->name('destroy');
});

// Schedule Day API Routes
Route::prefix('schedule-day')->name('schedule-day.')->group(function () {
    Route::get('/', [ScheduleDayController::class, 'index'])->name('index');
    Route::get('/{id}', [ScheduleDayController::class, 'show'])->name('show');
    Route::put('/update/{id}', [ScheduleDayController::class, 'update'])->name('update');
});

// User API Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// Teacher API  Routes
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', [UserController::class, 'getTeacher'])->name('index');
});

// User Status API Routes
Route::prefix('user-status')->name('user-status.')->group(function () {
    Route::get('/', [UserStatusController::class, 'index'])->name('index');
    Route::post('/store', [UserStatusController::class, 'store'])->name('store');
    Route::get('/{id}', [UserStatusController::class, 'show'])->name('show');
    Route::put('/update/{id}', [UserStatusController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [UserStatusController::class, 'destroy'])->name('destroy');
});

// Curriculum Lesson API Routes
Route::prefix('curriculum-lesson')->name('curriculum-lesson.')->group(function () {
    Route::get('/', [CurriculumLessonController::class, 'index'])->name('index');
    Route::post('/store', [CurriculumLessonController::class, 'store'])->name('store');
    Route::get('/{id}', [CurriculumLessonController::class, 'show'])->name('show');
    Route::put('/update/{id}', [CurriculumLessonController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CurriculumLessonController::class, 'destroy'])->name('destroy');
});

// Schedule Lesson Hour API Routes
Route::prefix('schedule-lesson-hour')->name('schedule-lesson-hour.')->group(function () {
    Route::get('/', [ScheduleLessonHourController::class, 'index'])->name('index');
    Route::post('/store', [ScheduleLessonHourController::class, 'store'])->name('store');
    Route::get('/{id}', [ScheduleLessonHourController::class, 'show'])->name('show');
    Route::put('/update/{id}', [ScheduleLessonHourController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [ScheduleLessonHourController::class, 'destroy'])->name('destroy');
});
