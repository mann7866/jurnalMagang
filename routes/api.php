<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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
    Route::middleware('role:admin')->prefix('/administrator')->name('administrator')->group(function(){

        // teacher route
        Route::controller(App\Http\Controllers\api\Admin\TeacherController::class)->prefix('/teacher')->name('teacher.')->group(function(){
            Route::get('/get/data','getData')->name('get');
            Route::post('/store','store')->name('store');
            Route::put('/update/{id}','update')->name('update');
            Route::delete('/destroy/{id}','destroy')->name('destroy');
        });

        // student route
        Route::controller(App\Http\Controllers\api\Admin\StudentController::class)->prefix('/student')->name('student.')->group(function(){
            Route::get('/get/data','getData')->name('get');
            Route::post('/store','store')->name('store');
            Route::put('/update/{id}','update')->name('update');
            Route::delete('/destroy/{id}','destroy')->name('destroy');
        });
    });

    // student role route
    Route::middleware('role:student')->prefix('student')->name('student')->group(function(){

        Route::controller(App\Http\Controllers\api\Student\JournalController::class)->prefix('/journal')->name('journal.')->group(function(){
            Route::get('/get/data','getData')->name('get');
            Route::post('/store','store')->name('store');
            Route::put('/update/{id}','update')->name('update');
            Route::delete('/destroy/{id}','destroy')->name('destroy');
        });
    });
});

