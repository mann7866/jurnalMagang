<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public Route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Route (login required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    // admin role route
    Route::middleware('role:admin')->prefix('/administrator')->name('administrator.')->group(function () {

        // teacher route
        Route::controller(App\Http\Controllers\api\Admin\TeacherController::class)->prefix('/teacher')->name('teacher.')->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // student route
        Route::controller(App\Http\Controllers\api\Admin\StudentController::class)->prefix('/student')->name('student.')->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // student teacher route
        Route::controller(App\Http\Controllers\api\Admin\StudentTeacherController::class)->prefix('/student/teacher')->name('student.teacher.')->group(function(){
            Route::post('/store','store')->name('store');
        });

        // monitored route
        Route::controller(App\Http\Controllers\api\Admin\MonitoredController::class)->prefix('/monitored')->name('monitored.')->group(function(){
            Route::get('/get/teachers','getMonitoredTeachers')->name('getMonitoredTeachers');
            Route::get('/get/student/by/teacher/{id}', 'getMonitoredStudentsByTeacherId')->name('getMonitoredStudentsByTeacherId');
            Route::get('/get/student/all','getAllStudent')->name('getAllStudent');
            Route::get('/get/journal/today','getAllJournalToDay')->name('getAllJournalToDay');
            Route::get('/get/student/{id}/journal', 'getJurnalByStudentId')->name('getJurnalByStudentId');
        });
    });

    // teacher role route
    Route::middleware('role:teacher')->prefix('/teacher')->name('teacher.')->group(function () {
        // journal route
        Route::controller(App\Http\Controllers\Api\Teacher\MonitoredController::class)->prefix('/monitored')->name('monitored.')->group(function () {
            Route::get('/get/students', 'getMonitoredStudents')->name('getMonitoredStudents');
            Route::get('/get/student/{id}/journal', 'getJurnalByStudentId')->name('getJurnalByStudentId');
            Route::get('/get/all/student/journal/today/by/teacher', 'getAllJournalToDayByTeacherId')->name('getAllJournalToDayByTeacherId');
        });
    });

    // student role route
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {

        // journal route
        Route::controller(App\Http\Controllers\api\Student\JournalController::class)->prefix('/journal')->name('journal.')->group(function () {
            Route::get('/get/data', 'getData')->name('get');
            Route::post('/store', 'store')->name('store');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
    });
});
