<?php


use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\WeekController;
use App\Livewire\Calendar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::component('calendar', Calendar::class);
Auth::routes(['register' => false]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    [
        'prefix' => 'dashboard',
        'as' => 'dashboard.',
        // 'middleware'=>'auth'

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
        Route::get('/classroom_students',[ReportsController::class, 'classrooms'])->name('classroom_students');
        Route::get('/view_students/{id}', [ReportsController::class, 'view_students'])->name('view_students');
        Route::get('/students_report/{id}', [ReportsController::class, 'classroom_students_report'])->name('students_report');
        Route::get('/students_report', [ReportsController::class, 'all_students_report'])->name('students_reports');
    }
);





