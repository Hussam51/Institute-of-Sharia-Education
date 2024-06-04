<?php


use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\WeekController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes(['register' => false]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    [
        'prefix' => 'dashboard',
        'as' => 'dashboard.',

    ],
    function () {
        Route::get('/', function () {
            return view('dashboard');
        });
        Route::resource("departments", DepartmentController::class)->except('create', 'edit');
        Route::resource("classrooms", ClassroomController::class)->except('create', 'edit');
        Route::patch('/delete-checked', [ClassroomController::class, 'deleteChecked'])->name('classrooms.delete-checked');
        Route::resource('teachers', TeacherController::class)->except('create', 'edit');
        Route::resource('subjects', SubjectController::class)->except('create', 'edit');
        Route::resource('students', StudentController::class);
        Route::get('/depclasses/{id}', [StudentController::class, 'departmentClassrooms'])->name('ajaxclassrooms');
        Route::resource('/attendences', AttendanceController::class);
        Route::resource('/week_tables', WeekController::class);
        Route::resource('/exam_tables', ExamController::class);
    }
);





