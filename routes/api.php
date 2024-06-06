<?php

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
    Route::post('/refresh', [TeacherController::class, 'refresh']);
    Route::get('/teacher-profile', [TeacherController::class, 'userProfile']);  
     
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth/student'

], function ($router) {
    Route::post('/login', [StudentController::class, 'login']);
    Route::post('/logout', [StudentController::class, 'logout']);
    Route::post('/refresh', [StudentController::class, 'refresh']);
    Route::get('/student-profile', [StudentController::class, 'userProfile']);  
    Route::get('/student-classroom', [StudentController::class, 'userclassroom']);  
    
});


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/