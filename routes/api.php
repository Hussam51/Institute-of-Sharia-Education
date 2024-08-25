<?php

use App\Http\Controllers\Api\AdviserController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth/teacher'

], function ($router) {
    Route::post('/login', [TeacherController::class, 'login']);
    Route::post('/logout', [TeacherController::class, 'logout']);
    Route::get('/teacher_profile', [TeacherController::class, 'userProfile']);
    Route::get('/teacher_showStudentQuestions', [TeacherController::class, 'showStudentQuestions']);
    Route::post('/teacher_replyToQuestion', [TeacherController::class, 'replyToQuestion']);
    Route::post('/teacher_uploadFile', [TeacherController::class, 'uploadFile']);
    Route::get('/teacher_teacherFiles', [TeacherController::class, 'teacherFiles']);
    Route::post('/teacher_showExamTableByClassroomId', [TeacherController::class, 'showExamTableByClassroomId']);
    Route::get('/teacher_showMonitoringTable', [TeacherController::class, 'showMonitoringTable']);
    Route::get('/teacher_showWeekTable', [TeacherController::class, 'showWeekTable']);
    Route::get('/teacher_showQuestionReplies', [TeacherController::class, 'showQuestionReplies']);
    Route::patch('/teacher_updateQuestionReply', [TeacherController::class, 'updateQuestionReply']);
    Route::delete('/teacher_deleteQuestionReply', [TeacherController::class, 'deleteQuestionReply']);
    Route::delete('/teacher_deleteFile', [TeacherController::class, 'deleteFile']);
    Route::post('/teacher_updateFile', [TeacherController::class, 'updateFile']);
    Route::post('/teacher_sendHomeworkOrLesson', [TeacherController::class, 'sendHomeworkOrLesson']);
    Route::get('/teacher_getClasses', [TeacherController::class, 'getClasses']);
    Route::post('/teacher_getSubjectsByClassroom', [TeacherController::class, 'getSubjectsByClassroom']);
    Route::get('/teacher_showGuards', [TeacherController::class, 'showGuards']);
    Route::get('/teacher_getNextLessonForTeacher', [TeacherController::class, 'getNextLessonForTeacher']);
    Route::get('/teacher_getQuestionById', [TeacherController::class, 'getQuestionById']);




    // Route::get('/teacher_replyToStudentQuestions', [TeacherController::class, 'replyToStudentQuestions']);





   //Route::post('/refresh', [TeacherController::class, 'refresh']);

});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth/adviser'

], function ($router) {
    Route::post('/login', [AdviserController::class, 'login']);
    Route::post('/logout', [AdviserController::class, 'logout']);
    Route::post('/adviser_replyToConsult', [AdviserController::class, 'replyToConsult']);
    Route::get('/adviser_showStudentConsult', [AdviserController::class, 'showStudentConsult']);
    Route::delete('/adviser_deleteConsultReply', [AdviserController::class, 'deleteConsultReply']);
    Route::patch('/adviser_updateConsultReply', [AdviserController::class, 'updateConsultReply']);
    Route::get('/adviser_showConsultReplies', [AdviserController::class, 'showConsultReplies']);
    Route::get('/adviser_showGuards', [AdviserController::class, 'showGuards']);
    Route::get('/adviser_getConsultById', [AdviserController::class, 'getConsultById']);



    //Route::post('/refresh', [AdviserController::class, 'refresh']);
    //Route::get('/adviser_profile', [AdviserController::class, 'userProfile']);

});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth/monitor'

], function ($router) {
    Route::post('/login', [MentorController::class, 'login']);
    Route::post('/logout', [MentorController::class, 'logout']);
    Route::post('/mentor_markAttendance', [MentorController::class, 'markAttendance']);
    Route::post('/mentor_showStudent', [MentorController::class, 'showStudent']);
    Route::get('/mentor_showGuards', [MentorController::class, 'showGuards']);
    //Route::get('/mentor_QRmarkAttendanceForTeacher', [MentorController::class, 'QRmarkAttendanceForTeacher']);
    Route::post('/mentor_checkTeacherAttendance', [MentorController::class, 'checkTeacherAttendance']);
    Route::get('/mentor_getClasses', [MentorController::class, 'getClasses']);





    //Route::get('/mentor_profile', [MentorController::class, 'userProfile']);
    //Route::post('/refresh', [MentorController::class, 'refresh']);
});




Route::group([

    'middleware' => 'api',
    'prefix' => 'auth/student'

], function ($router) {
    Route::post('/login', [StudentController::class, 'login']);
    Route::post('/logout', [StudentController::class, 'logout']);
    Route::get('/student_profile', [StudentController::class, 'userProfile']);
    Route::post('/student_sendConsult', [StudentController::class, 'sendConsult']);
    Route::post('/student_askQuestion', [StudentController::class, 'askQuestion']);
    Route::get('/student_getStudentRate', [StudentController::class, 'getStudentRate']);
    Route::get('/student_showQuestionReplies', [StudentController::class, 'showQuestionReplies']);
    Route::get('/student_showConsultReplies', [StudentController::class, 'showConsultReplies']);
    Route::post('/student_showExamTableByClassroomId', [StudentController::class, 'showExamTableByClassroomId']);
    Route::post('/student_showWeekTableByClassroomId', [StudentController::class, 'showWeekTableByClassroomId']);
    Route::post('/student_showHomework', [StudentController::class, 'showHomework']);
    Route::get('/student_showFiles', [StudentController::class, 'showFiles']);
    Route::get('/student_downloadPDF', [StudentController::class, 'downloadPDF']);
    Route::get('/student_showEntertainmentQuiz', [StudentController::class, 'showEntertainmentQuiz']);
    Route::get('/student_showAllQuestion', [StudentController::class, 'showAllQuestion']);
    Route::get('/student_showAllConsult', [StudentController::class, 'showAllConsult']);
    Route::get('/student_getStudentsSortedByMarks', [StudentController::class, 'getStudentsSortedByMarks']);
    Route::get('/student_getOneStudentMarkAndRank', [StudentController::class, 'getOneStudentMarkAndRank']);
    Route::get('/student_showDegrees', [StudentController::class, 'showDegrees']);
    Route::get('/student_showDegreeFinalExam', [StudentController::class, 'showDegreeFinalExam']);
    Route::get('/student_showDegreeQuiz', [StudentController::class, 'showDegreeQuiz']);
    Route::get('/student_showDegreeParticipation', [StudentController::class, 'showDegreeParticipation']);
    Route::get('/student_showDegreeOral', [StudentController::class, 'showDegreeOral']);
    Route::get('/student_showDegreeWritten', [StudentController::class, 'showDegreeWritten']);
    Route::get('/student_showDegreeActive', [StudentController::class, 'showDegreeActive']);
    Route::get('/student_showGuards', [StudentController::class, 'showGuards']);
    Route::post('/student_getSubjectsByClassroom', [StudentController::class, 'getSubjectsByClassroom']);
    Route::get('/student_showSubject', [StudentController::class, 'showSubject']);
    Route::get('/student_showTaqsimDegree', [StudentController::class, 'showTaqsimDegree']);
    Route::get('/student_getStudentRank', [StudentController::class, 'getStudentRank']);
    Route::get('/student_getQuestionById', [StudentController::class, 'getQuestionById']);
    Route::get('/student_getConsultById', [StudentController::class, 'getConsultById']);
    Route::post('/student_sendNoteToStudent', [StudentController::class, 'sendNoteToStudent']);



    Route::delete('/student_deleteConsult', [StudentController::class, 'deleteConsult']);
    Route::delete('/student_deleteQuestion', [StudentController::class, 'deleteQuestion']);
    Route::patch('/student_updateQuestion', [StudentController::class, 'updateQuestion']);
    Route::patch('/student_updateConsult', [StudentController::class, 'updateConsult']);








    //    Route::get('/student_show', [StudentController::class, 'show']);
//    Route::get('/student_show1', [StudentController::class, 'show1']);
    //Route::get('/student_downloadLibrary', [StudentController::class, 'downloadLibrary']);
    //Route::get('/student_download/{id}', [StudentController::class, 'download']);
    //Route::get('/student_getStudentNotes', [StudentController::class, 'getStudentNotes']);
    // Route::get('/student_showStudentAttendance', [StudentController::class, 'showStudentAttendance']);
    // Route::get('/student_index', [StudentController::class, 'index']);
    //Route::get('/student_showDuties', [StudentController::class, 'showDuties']);
    // Route::get('/student_getAdminNotesToParents', [StudentController::class, 'getAdminNotesToParents']);
    //Route::get('/student_getHonorRoll/{subject_id}', [StudentController::class, 'getHonorRoll']);
    //Route::get('/student-classroom', [StudentController::class, 'userclassroom']);
    //Route::post('/refresh', [StudentController::class, 'refresh']);


});

Route::group([

'middleware' => 'api',
    'prefix' => 'auth/parent'

], function ($router) {
    Route::post('/login', [ParentController::class, 'login']);
    Route::post('/logout', [ParentController::class, 'logout']);
    Route::get('/parent_showStudentProfile', [ParentController::class, 'showStudentProfile']);


    Route::get('/parent_getStudentNotes1', [ParentController::class, 'getStudentNotes1']);
    Route::get('/parent_getAllTransport', [ParentController::class, 'getAllTransport']);
    Route::get('/parent_showTransportById', [ParentController::class, 'showTransportById']);

    Route::get('/parent_showBusNotes', [ParentController::class, 'showBusNotes']);
    Route::get('/parent_showTransportByTimeOrLocation', [ParentController::class, 'showTransportByTimeOrLocation']);
    Route::get('/parent_getStudentRate', [ParentController::class, 'getStudentRate']);
    Route::get('/parent_showStudentAttendance', [ParentController::class, 'showStudentAttendance']);
    Route::post('/student_sendNote', [ParentController::class, 'sendNote']);
    Route::get('/parent_getAllSentNotes', [ParentController::class, 'getAllSentNotes']);
    Route::post('/parent_showExamTableByClassroomId', [ParentController::class, 'showExamTableByClassroomId']);
    Route::post('/parent_showWeekTableByClassroomId', [ParentController::class, 'showWeekTableByClassroomId']);
    Route::delete('/parent_deleteNotes', [ParentController::class, 'deleteNotes']);
    Route::patch('/parent_updateNotes', [ParentController::class, 'updateNotes']);
    Route::get('/parent_showDegrees', [ParentController::class, 'showDegrees']);
    Route::get('/parent_showDegreeFinalExam', [ParentController::class, 'showDegreeFinalExam']);
    Route::get('/parent_showDegreeQuiz', [ParentController::class, 'showDegreeQuiz']);
    Route::get('/parent_showDegreeParticipation', [ParentController::class, 'showDegreeParticipation']);
    Route::get('/parent_showDegreeOral', [ParentController::class, 'showDegreeOral']);
    Route::get('/parent_showDegreeWritten', [ParentController::class, 'showDegreeWritten']);
    Route::get('/parent_showDegreeActive', [ParentController::class, 'showDegreeActive']);
    Route::get('/parent_showGuards', [ParentController::class, 'showGuards']);
    Route::get('/parent_showTaqsimDegree', [ParentController::class, 'showTaqsimDegree']);


    // Route::post('/refresh', [ParentController::class, 'refresh']);

    // Route::get('/parent_getBusNote', [ParentController::class, 'getBusNote']);
    //Route::get('/parent_getStudentNotes', [ParentController::class, 'getStudentNotes']);

//Route::get('/parent-classroom', [ParentController::class, 'userclassroom']);

});



/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
