<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adviser;
use App\Models\AppNotification;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Consult;
use App\Models\ConsultReply;
use App\Models\Department;
use App\Models\Entertainment;
use App\Models\Exam;
use App\Models\Homework;
use App\Models\Library;
use App\Models\Mark;
use App\Models\Note;
use App\Models\Notification;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\StudentHomework;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\WeekTable;
use App\Notifications\NoteSentNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    /*    public function __construct()
       {
           $this->middleware('auth:api', ['except' => ['register']]);
       }
   */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->guard('student')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $user = auth()->guard('student')->user();

        // تحديد المرحلة التعليمية بناءً على اسم الصف
        if (str_contains($user->classroom->name, 'بكالوريا') ||
            str_contains($user->classroom->name, 'عاشر') ||
            str_contains($user->classroom->name, 'حادي عشر')) {
            $education_stage = 'ثانوي';
        } elseif (str_contains($user->classroom->name, 'سادس')||
            str_contains($user->classroom->name, 'سابع') ||
            str_contains($user->classroom->name, ' ثامن')||
            str_contains($user->classroom->name, 'تاسع')) {
            $education_stage = 'إعدادي';
        }
        elseif (str_contains($user->classroom->name, 'اول')||
            str_contains($user->classroom->name, 'ثاني') ||
            str_contains($user->classroom->name, ' ثالث')||
            str_contains($user->classroom->name, 'رابع')||
            str_contains($user->classroom->name, 'خامس')) {
            $education_stage = 'ابتدائي';
        } else {
            $education_stage = null;
        }

        $userData = $user->toArray();
        $userData['education_stage'] = $education_stage;

        return response()->json($userData);
    }

    public function userclassroom()
    {
        $user = auth()->guard('student')->user();
        $weektables = WeekTable::where('classroom_id', $user->classroom_id)->select(['session', 'day', 'subject_id'])->get();


        return response()->json($weektables);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('student')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        return response()->json($this->createNewToken(JWTAuth::refresh()));

    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *
     */
    public function getOneStudentMarkAndRank(Request $request)
    {
        $query = DB::table('students')
            ->selectRaw('students.*, AVG(marks.student_mark) as total_marks')
            ->join('marks', 'students.id', '=', 'marks.student_id')
            ->groupBy('students.id', 'students.first_name', 'students.last_name', 'students.email',
                'students.classroom_id', 'students.department_id', 'students.adviser_id', 'students.phone', 'students.password',
                'students.updated_at', 'students.created_at', 'students.image', 'students.data_birth')
            ->orderByDesc('total_marks');

        if ($request->has('student_id')) {
            $student = $query->where('students.id', $request->input('student_id'))->first();
            if (!$student) {
                return response()->json(['error' => 'Student not found'], 404);
            }
            $students = collect([$student]);
        }

        $rankedStudents = $students->map(function ($student, $index) {
            $student->rank = $index + 1;
            return $student;
        });

        return response()->json($rankedStudents);
    }





    public function getStudentsSortedByMarks(Request $request)
    {
        $query = DB::table('students')
            ->selectRaw('students.*, AVG(marks.student_mark) as total_marks')
            ->join('marks', 'students.id', '=', 'marks.student_id')///
            ->groupBy('students.id', 'students.first_name','students.last_name', 'students.email',
                'students.classroom_id', 'students.department_id', 'students.adviser_id', 'students.phone', 'students.password',
                'students.updated_at', 'students.created_at', 'students.image', 'students.data_birth');

        $students = $query
            ->orderByDesc('total_marks')
            ->get();

        // إضافة رقم الترتيب إلى المصفوفة
        $rankedStudents = $students->map(function ($student, $index) {
            $student->rank = $index + 1;
            return $student;
        });

        return response()->json($rankedStudents);
    }




    public function getStudentRank(Request $request)

    {
        $studentId= $request->input('student_id');
        $query = DB::table('students')
            ->selectRaw('students.*, AVG(marks.student_mark) as total_marks')
            ->join('marks', 'students.id', '=', 'marks.student_id')//////////
            ->groupBy('students.id', 'students.first_name','students.last_name', 'students.email',
                'students.classroom_id', 'students.department_id', 'students.adviser_id', 'students.phone', 'students.password',
                'students.updated_at', 'students.created_at', 'students.image', 'students.data_birth')
            ->orderByDesc('total_marks')
            ->get();

        $studentRank = $query->search(function ($item) use ($studentId) {
                return $item->id == $studentId;
            }) + 1;

        return response()->json(['student_rank' => $studentRank]);
    }








////////////////////////////////////
//    public function sendConsult(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'adviser_id' => 'required|exists:advisers,id',
//            'consult' => 'required|string',
//            'is_anonymous' => 'required|boolean',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->errors()], 422);
//        }
//
//        $adviser = Adviser::find($request->get('adviser_id'));
//
//        if (!$adviser) {
//            return response()->json(['errors' => ['adviser_id' => 'Invalid adviser ID']], 422);
//        }
//
//        $student = Student::find($request->get('student_id'));
//
//        if (!$student) {
//            return response()->json(['errors' => ['student_id' => 'Invalid student ID']], 422);
//        }
//
//        $consultation = new Consult([
//            'student_id' => $student->id,
//            'adviser_id' => $adviser->id,
//            'consult' => $request->get('consult'),
//            'status' => 'pending',
//            'is_anonymous' => $request->get('is_anonymous'),
//        ]);
//
//        $consultation->save();
//
//        $response = [
//            'message' => 'Consultation request sent successfully.',
//            'data' => [
//                'consult' => $consultation,
//            ],
//        ];
//
//        if (!$consultation->is_anonymous) {
//            $response['data']['student_full_name'] = $student->name;
//        }
//
//        return response()->json($response, 201);
//    }



    public function sendConsult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consult' => 'required|string',
            'is_anonymous' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::find($request->get('student_id'));
        if (!$student) {
            return response()->json(['errors' => ['student_id' => 'Invalid student ID']], 422);
        }

        if (!$student->department_id) {
            return response()->json(['errors' => ['department_id' => 'Student has no department ID']], 422);
        }

        $department = Department::find($student->department_id);
        if (!$department) {
            return response()->json(['errors' => ['department_id' => 'Invalid department ID']], 422);
        }

        $adviser = Adviser::where('department_id', $department->id)->first();

        if (!$adviser) {
            return response()->json(['errors' => ['adviser_id' => 'No adviser found for the department']], 422);
        }

        $consultation = new Consult([
            'student_id' => $student->id,
            'adviser_id' => $adviser->id,
            'consult' => $request->get('consult'),
            'status' => 'pending',
            'is_anonymous' => $request->get('is_anonymous'),
        ]);

        $consultation->save();

        $response = [
            'message' => 'Consultation request sent successfully.',
            'data' => [
                'consult' => $consultation,
            ],
        ];

        if (!$consultation->is_anonymous) {
            $response['data']['student_full_name'] = $student->first_name.' '.$student->last_name;
            $response['data']['adviser_full_name'] = $adviser->first_name.' '.$adviser->last_name;
        }

        return response()->json($response, 201);
    }

/////////////////////////////


    public function askQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'question' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subject = Subject::find($request->get('subject_id'));

        if (!$subject) {
            return response()->json(['errors' => ['subject_id' => 'Invalid subject ID']], 422);
        }

        $teacher = $subject->teacher;

        if (!$teacher) {
            return response()->json(['errors' => ['teacher' => 'No teacher assigned to this subject']], 422);
        }

        $student = Student::find($request->get('student_id'));

        if (!$student) {
            return response()->json(['errors' => ['student' => 'Invalid student']], 422);
        }

        $fullName = $student->first_name.' '.$student->last_name;

        $question = new Question([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'question' => $request->get('question'),
            'status' => 'pending',
        ]);

        $question->save();

        return response()->json([
            'message' => 'question sent successfully.',
            'data' => [
                'question' => $question,
                'student_full_name' => $fullName,
                'subject_id' => $subject->id,
                'subject_name' => $subject->name,
                'teacher_name' => $teacher->first_name.' '.$teacher->last_name,

            ],
        ], 201);
    }



    public function getStudentRate(Request $request)
    {
        // Validate the student ID
        $validator = Validator::make(['student_id' => $request->get('student_id')], [
            'student_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid student ID'], 400);
        }

        // Fetch the student's evaluations
        $student = Student::find($request->get('student_id'));

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $evaluations = $student->rates()->orderByDesc('created_at')->get();

        // Map the evaluations to an array with the necessary data
        $evaluationData = $evaluations->map(function ($evaluation) {
            return [
                'id' => $evaluation->id,
                'score' => $evaluation->score,
                'comment' => $evaluation->comment,
                'created_at' => $evaluation->created_at,
            ];
        });


        $totalScore = $student->rates()->sum('score');

        // Return the response
        return response()->json([
            'evaluations' => $evaluationData,
            'total_score' => $totalScore,
        ]);
    }











    public function getQuestionById(Request $request)
    {

        if (!auth()->guard('student')->check()) {
            return response()->json(['error' => 'Only student can view student consult.'], 403);
        }

        $questionId = $request->input('id');
        $question = Question::findOrFail($questionId);


        return response()->json([
         $question

        ]);
    }











    public function getConsultById(Request $request)
    {
        if (!auth()->guard('student')->check()) {
            return response()->json(['error' => 'Only student can view student consult.'], 403);
        }


        $consultId = $request->input('id');
        $consult = Consult::findOrFail($consultId);


        return response()->json([
            $consult
        ]);
    }








///////////////////////////////

    public function showQuestionReplies()
    {
        $replies = QuestionReply::with('teacher')
            ->get()
            ->map(function ($reply) {
                return [
                    'id' => $reply->id,
                    'teacher_id' => $reply->teacher_id,
                    'teacher_name' => $reply->teacher->first_name.''.$reply->teacher->last_name,
                    'question_id' => $reply->question_id,
                    'reply' => $reply->reply,
                    'created_at' => $reply->created_at,
                    'updated_at' => $reply->updated_at
                ];
            });

        return response()->json($replies);
    }


    public function showAllQuestion()
    {
        if (!auth()->guard('student')->check()) {
            return response()->json(['error' => 'Only student can view student question.'], 403);
        }

        $student = auth()->guard('student')->user();
        $question = $student->questions()->get();

        return response()->json($question);
    }


    public function showAllConsult()
    {
        if (!auth()->guard('student')->check()) {
            return response()->json(['error' => 'Only student can view student question.'], 403);
        }

        $student = auth()->guard('student')->user();
        $consult = $student->consult()->get();

        return response()->json($consult);
    }


///////////////////////////////////////////////////
    public function showConsultReplies()
    {
        $replies = ConsultReply::with('adviser', 'consult', 'consult.student', 'consult.student.department')
            ->get()
            ->map(function ($reply) {
                return [
                    'id' => $reply->id,
//                    'adviser_id' => $reply->adviser_id,
                    'adviser_name' => $reply->adviser->first_name.''. $reply->adviser->last_name,
                    'consult_id' => $reply->consult_id,
                    'consult_text' => $reply->consult->consult,
                    'student_name' => $reply->consult->is_anonymous ? ' المرسِل مجهول' : $reply->consult->student->first_name.''. $reply->consult->student->last_name,
                    'reply' => $reply->reply,
                    'created_at' => $reply->created_at,
                    'updated_at' => $reply->updated_at
                ];
            });

        return response()->json($replies);
    }
/////////////////////////////////////


    public function showExamTableByClassroomId(Request $request)
    {
        $classroom_id = $request->input('classroom_id');

        $examSchedules = Exam::where('classroom_id', $classroom_id)
            ->with('subject')
            ->get()
            ->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'term' => $exam->term,
                    'subject_id' => $exam->subject_id,
                    'subject_name' => $exam->subject->name,
                    'exam_date' => $exam->exam_date,
                    'exam_duration' => $exam->exam_duration,
                    'department_id' => $exam->department_id,
                    'classroom_id' => $exam->classroom_id,
                    'created_at' => $exam->created_at,
                    'updated_at' => $exam->updated_at,
                ];
            });

        return response()->json($examSchedules);
    }

//////////////////////////////////////

    public function showWeekTableByClassroomId(Request $request)
    {
        $classroom_id = $request->input('classroom_id');

        $weekSchedules = WeekTable::where('classroom_id', $classroom_id)
            ->with('subject')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'term' => $schedule->term,
                    'subject_id' => $schedule->subject_id,
                    'subject_name' => $schedule->subject->name,
                    'day' => $schedule->day,
                    'session' => $schedule->session,
                    'department_id' => $schedule->department_id,
                    'classroom_id' => $schedule->classroom_id,
                    'created_at' => $schedule->created_at,
                    'updated_at' => $schedule->updated_at,
                ];
            });

        return response()->json($weekSchedules);
    }

//////////////////////////////////////////
    public function showHomework(Request $request)
    {
        $classroom_id = $request->input('classroom_id');

        $home = Homework::where('classroom_id', $classroom_id)
            ->with('subject')
            ->get()
            ->map(function ($homework) {
                return [
                    'id' => $homework->id,
                    'subject_id' => $homework->subject_id,
                    'teacher_id' => $homework->teacher_id,
                    'classroom_id' => $homework->classroom_id,
                    'homework_name' => $homework->homework_name,
                    'type' => $homework->type,
                    'notes' => $homework->notes,
                    'date' => $homework->date,
                    'classroom_name' => $homework->classroom->name,
                    'subject_name' => $homework->subject ? $homework->subject->name : null,
                    'created_at' => $homework->created_at,
                    'updated_at' => $homework->updated_at,

                ];
            });
        return response()->json($home);

    }





    public function showFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $libraries = Library::where('status', 'approved')
            ->where('classroom_id', $request->get('classroom_id'))
            ->get();

        return response()->json($libraries);
    }


    public function downloadPDF(Request $request)
    {
        $id = $request->input('id');
        $file = Library::findOrFail($id);

        $filePath = public_path('uploads\\' . $file->file_url);
        return response()->download($filePath, $file->title . '.' . 'pdf');

    }


    public function deleteConsult(Request $request)
    {
        $consultId = $request->input('id');
        $consult = Consult::findOrFail($consultId);
        $consult->delete();

        return response()->json([
            'message' => 'consult deleted'
        ]);
    }


    public function updateConsult(Request $request)
    {

        $consultId = $request->input('id');

        $consult = Consult::findOrFail($consultId);

        $consult->update([
            'consult' => $request->input('consult'),
        ]);

        return response()->json([
            'message' => 'consult updated'
        ]);
    }


    public function deleteQuestion(Request $request)
    {
        $questionId = $request->input('id');
        $question = Question::findOrFail($questionId);
        $question->delete();

        return response()->json([
            'message' => 'question deleted'
        ]);
    }


    public function updateQuestion(Request $request)
    {

        $questionId = $request->input('id');

        $question = Question::findOrFail($questionId);

        $question->update([
            'question' => $request->input('question'),
        ]);

        return response()->json([
            'message' => 'question updated'
        ]);
    }


   //////////////////////////////////////////////edit/////////////////////////////////////////////

    public function showEntertainmentQuiz(Request $request)
    {
       
        $entertainment = Entertainment::first();

        return response()->json($entertainment);
    }










    public function showSubject(Request $request)
    {
        $subject = Subject::all();

        return response()->json($subject);

    }

    public function getSubjectsByClassroom(Request $request)
    {
        // Get the classroom ID from the request
        $classroomId = $request->input('classroom_id');

        // Validate the classroom ID
        if (!is_numeric($classroomId)) {
            return response()->json(['error' => 'Invalid classroom ID'], 400);
        }

        $subjects = Subject::where('classroom_id', $classroomId)->get();

        return response()->json($subjects);
    }










    private function getMarkDegree($main_type,$studentId)
{
     $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
       $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
        ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
        ->where('marks.student_id', $studentId)
         ->groupBy('subject_id', 'type');
 }])
    ->get()
    ->map(function ($subject) use (&$main_type) {
     $subject->average_marks = collect($subject->quizzes)
     ->groupBy('type')
      ->mapWithKeys(function ($quizzes, $type) {
     $totalMarks = $quizzes->sum('final_mark');
     $totalTypes = $quizzes->count();
     return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
 });
     $quizzes = $subject->quizzes->where('type', $main_type);
     unset($subject->average_quiz_mark);


     $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

      return $subject;
});

    $totalQuizMarks = $subjects->sum(function ($subject) use (&$main_type) {
    return $subject->average_quiz_mark * $subject->quizzes->where('type', $main_type)->count();


 });
     $totalQuizCount = $subjects->sum(function ($subject) use (&$main_type) {
     return $subject->quizzes->where('type', $main_type)->count();
});
     $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

    return $overallAverageQuizMark;
}




public function showTaqsimDegree(Request $request)
{
  $studentId = $request->input('student_id');

 return response()->json([

        //'subjects' => $subjects,
  'active' => $this->getMarkDegree("النشاط",$studentId),
  'written' => $this->getMarkDegree("الوظائف",$studentId),
  'oral' => $this->getMarkDegree("الشفهي",$studentId),
  'participation' => $this->getMarkDegree("المشاركة",$studentId),
  'quiz' => $this->getMarkDegree("المذاكرة",$studentId),
  'exam' => $this->getMarkDegree("الامتحان",$studentId),
 ]);
}



















       public function showDegrees(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $totalMarks = 0;
                $totalTypes = 0;

                foreach ($subject->quizzes as $quiz) {
                    $totalMarks += $quiz->final_mark;
                    $totalTypes++;

                }



                if ($totalTypes > 0) {
                    $subject->average_mark = ($totalMarks / $totalTypes) * 100 / 100;
                } else {
                    $subject->average_mark = 0;
                }
                return $subject;
            });

        $totalMarks = 0;
        $totalSubjects = 0;

        foreach ($subjects as $subject) {
            $totalMarks += $subject->average_mark;
            $totalSubjects++;
        }

        $finalAverageMark = ($totalMarks / $totalSubjects);

        return response()->json([
            'subjects' => $subjects,
            'finalAverageMark'=>$finalAverageMark
        ]);
    }




       public function showDegreeFinalExam(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $subject->average_marks = collect($subject->quizzes)
                    ->groupBy('type')
                    ->mapWithKeys(function ($quizzes, $type) {
                        $totalMarks = $quizzes->sum('final_mark');
                        $totalTypes = $quizzes->count();
                        return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
                    });

                $quizzes = $subject->quizzes->where('type', 'الامتحان');
                unset($subject->average_quiz_mark);


                $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

                return $subject;
            });

        $totalQuizMarks = $subjects->sum(function ($subject) {
            return $subject->average_quiz_mark * $subject->quizzes->where('type', 'الامتحان')->count();


        });
        $totalQuizCount = $subjects->sum(function ($subject) {
            return $subject->quizzes->where('type', 'الامتحان')->count();
        });
        $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

        return response()->json([

            //'subjects' => $subjects,
            'علامة الامتحان' => $overallAverageQuizMark
        ]);
    }




       public function showDegreeQuiz(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $subject->average_marks = collect($subject->quizzes)
                    ->groupBy('type')
                    ->mapWithKeys(function ($quizzes, $type) {
                        $totalMarks = $quizzes->sum('final_mark');
                        $totalTypes = $quizzes->count();
                        return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
                    });

                $quizzes = $subject->quizzes->where('type', 'المذاكرة');
                unset($subject->average_quiz_mark);


                $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

                return $subject;
            });

        $totalQuizMarks = $subjects->sum(function ($subject) {
            return $subject->average_quiz_mark * $subject->quizzes->where('type', 'المذاكرة')->count();


        });
        $totalQuizCount = $subjects->sum(function ($subject) {
            return $subject->quizzes->where('type', 'المذاكرة')->count();
        });
        $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

        return response()->json([

            //'subjects' => $subjects,
            'علامة المذاكرة' => $overallAverageQuizMark
        ]);
    }




      public function showDegreeParticipation(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $subject->average_marks = collect($subject->quizzes)
                    ->groupBy('type')
                    ->mapWithKeys(function ($quizzes, $type) {
                        $totalMarks = $quizzes->sum('final_mark');
                        $totalTypes = $quizzes->count();
                        return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
                    });

                $quizzes = $subject->quizzes->where('type', 'المشاركة');
                unset($subject->average_quiz_mark);


                $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

                return $subject;
            });

        $totalQuizMarks = $subjects->sum(function ($subject) {
            return $subject->average_quiz_mark * $subject->quizzes->where('type', 'المشاركة')->count();


        });
        $totalQuizCount = $subjects->sum(function ($subject) {
            return $subject->quizzes->where('type', 'المشاركة')->count();
        });
        $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

        return response()->json([

            //'subjects' => $subjects,
            'علامة المشاركة' => $overallAverageQuizMark
        ]);
    }



      public function showDegreeOral(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $subject->average_marks = collect($subject->quizzes)
                    ->groupBy('type')
                    ->mapWithKeys(function ($quizzes, $type) {
                        $totalMarks = $quizzes->sum('final_mark');
                        $totalTypes = $quizzes->count();
                        return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
                    });

                $quizzes = $subject->quizzes->where('type', 'الشفهي');
                unset($subject->average_quiz_mark);


                $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

                return $subject;
            });

        $totalQuizMarks = $subjects->sum(function ($subject) {
            return $subject->average_quiz_mark * $subject->quizzes->where('type', 'الشفهي')->count();


        });
        $totalQuizCount = $subjects->sum(function ($subject) {
            return $subject->quizzes->where('type', 'الشفهي')->count();
        });
        $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

        return response()->json([

            //'subjects' => $subjects,
            'علامة الشفهي' => $overallAverageQuizMark
        ]);
    }



       public function showDegreeWritten(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $subject->average_marks = collect($subject->quizzes)
                    ->groupBy('type')
                    ->mapWithKeys(function ($quizzes, $type) {
                        $totalMarks = $quizzes->sum('final_mark');
                        $totalTypes = $quizzes->count();
                        return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
                    });

                $quizzes = $subject->quizzes->where('type', 'الوظائف');
                unset($subject->average_quiz_mark);


                $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

                return $subject;
            });

        $totalQuizMarks = $subjects->sum(function ($subject) {
            return $subject->average_quiz_mark * $subject->quizzes->where('type', 'الوظائف')->count();


        });
        $totalQuizCount = $subjects->sum(function ($subject) {
            return $subject->quizzes->where('type', 'الوظائف')->count();
        });
        $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

        return response()->json([

            //'subjects' => $subjects,
            'علامة الوظائف' => $overallAverageQuizMark
        ]);
    }




       public function showDegreeActive(Request $request)
    {
        $studentId = $request->input('student_id');

        $subjects = Subject::with(['quizzes' => function ($query) use ($studentId) {
            $query->selectRaw('subject_id, type, MAX(student_mark) as final_mark')
                ->join('marks', 'quizzes.id', '=', 'marks.quiz_id')
                ->where('marks.student_id', $studentId)
                ->groupBy('subject_id', 'type');
        }])
            ->get()
            ->map(function ($subject) {
                $subject->average_marks = collect($subject->quizzes)
                    ->groupBy('type')
                    ->mapWithKeys(function ($quizzes, $type) {
                        $totalMarks = $quizzes->sum('final_mark');
                        $totalTypes = $quizzes->count();
                        return [$type => $totalTypes > 0 ? $totalMarks / $totalTypes * 100 / 100 : 0];
                    });

                $quizzes = $subject->quizzes->where('type', 'النشاط');
                unset($subject->average_quiz_mark);


                $subject->average_quiz_mark = $quizzes->count() > 0 ? $quizzes->avg('final_mark') * 100 / 100 : 0;

                return $subject;
            });

        $totalQuizMarks = $subjects->sum(function ($subject) {
            return $subject->average_quiz_mark * $subject->quizzes->where('type', 'النشاط')->count();


        });
        $totalQuizCount = $subjects->sum(function ($subject) {
            return $subject->quizzes->where('type', 'النشاط')->count();
        });
        $overallAverageQuizMark = $totalQuizCount > 0 ? $totalQuizMarks / $totalQuizCount * 100 / 100 : 0;

        return response()->json([

            //'subjects' => $subjects,
            'علامة النشاط' => $overallAverageQuizMark
        ]);
    }


    public function showGuards()
    {
        $guards = array_keys(config('auth.guards'));

        $arabicGuards = [];
        foreach ($guards as $guard) {
            if ($guard !== 'web' && $guard !== 'sanctum' && $guard !== 'api') {
                switch ($guard) {
                    case 'student':
                        echo 'type';
                        $arabicGuards[] = 'طالب';
                        break;
                    case 'parent':
                        $arabicGuards[] = 'ولي أمر';
                        break;
                    case 'teacher':
                        $arabicGuards[] = 'معلم';
                        break;
                    case 'monitor':
                        $arabicGuards[] = 'موجه';
                        break;
                    case 'adviser':

                        $arabicGuards[] = 'مرشد';
                        break;
                    default:
                        $arabicGuards[] = $guard;
                        break;
                }
            }
        }

        return response()->json($arabicGuards);
    }


/*

    public function sendNoteToStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'content' => 'required|string',
            'notification_type' => 'required|string|in:exam_schedule,file_upload,comment,consultation_response',
        ]);

        $studentId = $request->input('student_id');
        $noteContent = $request->input('content');
        $noteType = $request->input('notification_type');

        // إنشاء الملاحظة
        $note = Notification::create([
            'content' => $noteContent,
            'student_id' => $studentId,
            'notification_type' => $noteType,
        ]);

        // إرسال الإشعار للطالب
        $student = Student::find($studentId);
        $student->notify(new NoteSentNotification($noteContent, $noteType));

        // إرسال الإشعار لأولياء الأمور
        $parents = $student->parents; // الحصول على أولياء الأمور
        foreach ($parents as $parent) {
            $parent->notify(new NoteSentNotification($noteContent, $noteType));
        }

        return response()->json(['message' => 'Note sent successfully.']);
    }
*/







    protected function createNewToken($token)
    {
        $user = auth()->guard('student')->user();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'department_id' => $user->department_id,
                'adviser_id' => $user->adviser_id,
                'classroom_id' => $user->classroom_id,
                'password' => $user->password,
                'phone' => $user->phone,
                'image' => $user->image,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'data_birth' =>$user->data_birth,
                'full_name'=>$user->first_name.' '.$user->last_name
            ],
        ]);
    }



}


