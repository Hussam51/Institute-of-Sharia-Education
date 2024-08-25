<?php

use App\Events\FileUpload;
use App\Http\Controllers\Dashboard\AdvertisementController;
use App\Http\Controllers\Dashboard\AdviserController;
use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\TransportController;
use App\Http\Controllers\Dashboard\TransportNotesController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\EntertainmentController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\HomeworkController;
use App\Http\Controllers\Dashboard\LibraryController;
use App\Http\Controllers\Dashboard\MarkController;
use App\Http\Controllers\Dashboard\MonitorController;
use App\Http\Controllers\Dashboard\NoteController;
use App\Http\Controllers\Dashboard\ParentController;
use App\Http\Controllers\Dashboard\QuizController;
use App\Http\Controllers\Dashboard\RatingController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TeacherAttendenceController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\TeacherMonitoringController;
use App\Http\Controllers\Dashboard\TeacherWeekTableController;
use App\Http\Controllers\Dashboard\WeekController;
use App\Livewire\Calendar;
use App\Models\TeacherAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


 






Livewire::component('calendar', Calendar::class);
Auth::routes(['register' => false]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// event(new FileUpload($validatedData));

Route::group(
  [
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => 'auth'

  ],
  function () {
    /*  Route::get('/', function () {
            return view('dashboard');
        });
      */
    Route::resource('ratings',RatingController::class);// rating //
    Route::resource("departments", DepartmentController::class)->except('create', 'edit');
    Route::resource("classrooms", ClassroomController::class)->except('create', 'edit');
    Route::patch('/delete-checked', [ClassroomController::class, 'deleteChecked'])->name('classrooms.delete-checked');
    Route::resource('teachers', TeacherController::class)->except('create', 'edit');
    Route::resource('subjects', SubjectController::class)->except('create', 'edit');
    Route::resource('students', StudentController::class);
    Route::resource('parents', ParentController::class);
    Route::resource('advisers', AdviserController::class);
    Route::resource('monitors', MonitorController::class);

    /// reject and approve Request file Upload 
    Route::get('libraries/filesPendingRequests',[LibraryController::class,'filesPendingRequests'] )->name('files-Pending-Requests');
    Route::get('libraries/filesApprovedRequests',[LibraryController::class,'filesApprovedRequests'] )->name('files-Approved-Requests');
    Route::get('libraries/filesRejectedRequests',[LibraryController::class,'filesRejectedRequests'] )->name('files-Rejected-Requests');
    Route::post('libraries/uploads_change_status/{id}',[LibraryController::class,'uploadsChangeStatus'] )->name('uploads-change-status');
    Route::get('libraries/download-pdf/{id}',[LibraryController::class,'downloadPDF'] )->name('download-pdf');
    ///
    Route::resource('libraries', LibraryController::class);
    Route::resource('buses', TransportController::class);
    Route::get('/class_subjects/{id}', [QuizController::class, 'class_subjects'])->name('ajax_subjects');
    Route::resource('quizzes', QuizController::class);
    Route::resource('quiz_results', MarkController::class);
    Route::get('/quiz_marks/{classroom_id}/{quiz_id}', [QuizController::class, 'quiz_marks'])->name('quiz_marks');
    Route::get('/depclasses/{id}', [StudentController::class, 'departmentClassrooms'])->name('ajaxclassrooms');
    Route::get('/classStudents/{id}', [ParentController::class, 'class_students'])->name('ajaxstudents');
    Route::resource('/attendences', AttendanceController::class);
    Route::resource('/advertisements', AdvertisementController::class);
    Route::resource('/week_tables', WeekController::class);
    Route::resource('/exam_tables', ExamController::class);
    Route::get('/classroom_students', [ReportsController::class, 'classrooms'])->name('classroom_students');
    Route::get('/view_students/{id}', [ReportsController::class, 'view_students'])->name('view_students');
    Route::get('/students_report/{id}', [ReportsController::class, 'classroom_students_report'])->name('students_report');
    Route::get('/students_report', [ReportsController::class, 'all_students_report'])->name('students_reports');
   /// new  feauteres
    Route::get('parent_feedback',[NoteController::class,'parentFeedback'])->name('parent-feedback');
    Route::resource('entertainments',EntertainmentController::class);// entertainments //done✅
    Route::resource('homeworks', HomeworkController::class);// homeworks done✅
    Route::resource('behaviors',NoteController::class);// behavior //done✅
    Route::resource('bus_notes',TransportNotesController::class); //bus notes //done✅
    Route::get('/classTeachers/{id}', [ParentController::class, 'class_teachers'])->name('ajaxteachers'); //done✅
    Route::resource('teacher_monitorings',TeacherMonitoringController::class); // teacher monitorings //
    Route::resource('teacher_weekTable',TeacherWeekTableController::class); // teacher monitorings //
    Route::get('teacher_attendences/report',[TeacherAttendenceController::class,'report'] )->name('teacher_attendences.report');

    Route::resource('teacher_attendences',TeacherAttendenceController::class); // teacher attendences //






  }
);
