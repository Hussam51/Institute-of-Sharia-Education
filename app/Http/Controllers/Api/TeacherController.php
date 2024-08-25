<?php

namespace App\Http\Controllers\Api;

use App\Events\FileUpload;
use App\Http\Controllers\Controller;
use App\Models\Adviser;
use App\Models\Classroom;
use App\Models\Consult;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Homework;
use App\Models\Library;
use App\Models\Notification;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherMonitoringTable;
use App\Models\TeacherWeekTimes;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class TeacherController extends Controller
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


    use ImageTrait;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'=>'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $validator->validated();

        if (!$token = auth()->guard('teacher')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->createNewToken ($token);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function userProfile()
    {
        return response()->json(auth()->guard('teacher')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */


    public function logout()
    {
        auth()->guard('teacher')->logout();

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
     */

//

    public function showStudentQuestions()
    {
        if (!auth()->guard('teacher')->check()) {
            return response()->json(['error' => 'Only teachers can view student questions.'], 403);
        }

        $teacher = auth()->guard('teacher')->user();
        $questions = $teacher->questions()->with('student')->get();

        $questionsWithStudentNames = $questions->map(function ($question) {
            return [
                'id' => $question->id,
                'teacher_id' => $question->teacher_id,
                'student_id' => $question->student_id,
                'student_name' => $question->student->first_name.''.$question->student->last_name,
                'question' => $question->question,
                'answered' => $question->answered,
                'created_at' => $question->created_at,
                'updated_at' => $question->updated_at,
            ];
        });

        return response()->json($questionsWithStudentNames);
    }


    public function showQuestionReplies()
    {

        $replies = \App\Models\QuestionReply::all();


        return response()->json($replies);
    }


    public function replyToQuestion(Request $request)
    {
        if (!auth()->guard('teacher')->check()) {
            return response()->json(['error' => 'Only teachers can reply to student questions.'], 403);
        }

        $questionId = $request->input('question_id');
        $question = Question::findOrFail($questionId);

        // Get the question text and student name
        $questionText = $question->question;
        $studentName =  $question->student->first_name.''.$question->student->last_name;

        $question->answered = true;
        $question->save();

        $answer = $question->replies()->create([
            'reply' => $request->input('reply'),
            'teacher_id' => $request->input('teacher_id'),
        ]);

        return response()->json([
            'question_text' => $questionText,
            'student_name' => $studentName,
            'answer' => $answer
        ]);
    }

//    }
    public function uploadFile(Request $request)
    {

        $validatedData = $request->validate([

            'title' => 'required|string',
            'subject_id' => 'required|string',
            'classroom_id' => 'required',
            'type' => 'required|in:book,document',

        ]);
        $fileUpload = $request->file('file_url');
        $file_url = $this->uploadImage($fileUpload, 'library');
        $validatedData['teacher_id'] = auth()->guard('teacher')->user()->id;
        $validatedData['file_url'] = $file_url;
        $fileUploadRequest = Library::create($validatedData);
        
// notifications
        $notifications = new Notification();
        $notifications->teacherName = auth()->guard('teacher')->user()->first_name . ' ' . auth()->guard('teacher')->user()->last_name;
        $notifications->title = $request->title;
        $notifications->save();
        event(new FileUpload($validatedData));

        return response()->json([
            'Uploaded successfully',
            $fileUploadRequest
        ],
            200);
    }



    public function teacherFiles()
    {

        $files = Library::whereNotNull('teacher_id')->where('teacher_id', auth()->guard('teacher')->user()->id)
            ->where('status', 'approved')
            ->get();

        return response()->json($files
            ,200);

    }


////////////////////////////////////
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


    public function showMonitoringTable(Request $request)
    {
        $teacher = auth()->guard('teacher')->user();

        $monitorSchedules = TeacherMonitoringTable::where('teacher_id', $teacher->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($monitorSchedules);
    }



    public function showWeekTable(Request $request)
    {
        $teacher = auth()->guard('teacher')->user();

        $weekSchedules = TeacherWeekTimes::where('teacher_id', $teacher->id)
            ->with(['subject', 'classroom'])
            ->orderBy('created_at', 'desc')
            ->get();

        $weekSchedulesWithNames = $weekSchedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'day' => $schedule->day,
                'teacher_id' => $schedule->teacher_id,
                'classroom_id' => $schedule->classroom_id,
                'classroom_name' => $schedule->classroom ? $schedule->classroom->name : null,
                'subject_name' => $schedule->teacher->subject ? $schedule->teacher->subject->name : null,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'created_at' => $schedule->created_at,
                'updated_at' => $schedule->updated_at,
            ];
        });

        return response()->json($weekSchedulesWithNames);
    }


//////////////////////////////////////////////edit///////////////////////////////////////
    public function getNextLessonForTeacher(Request $request)
    {
        $teacherId = auth()->guard('teacher')->user();

        $currentTime = now();

        $nextLesson = TeacherWeekTimes::where('teacher_id', $teacherId)
            ->where('day', $currentTime->format('l'))
            ->where('start_time', '>', $currentTime->format('H'))
            ->orderBy('start_time', 'asc')
            ->first();

        if ($nextLesson) {
            $classroom = Classroom::find($nextLesson->classroom_id);
            return [
                'day' => $nextLesson->day,
                'start_time' => $nextLesson->start_time,
                'end_time' => $nextLesson->end_time,
                'classroom' => $classroom->name
            ];
        } else {
            return null;
        }
    }









    public function deleteQuestionReply(Request $request)
    {
        $questionReplyId = $request->input('id');
        $questionReply = QuestionReply::findOrFail($questionReplyId);
        $questionReply->delete();

        return response()->json([
            'message' => 'questionReply deleted'
        ]);
    }


    public function updateQuestionReply(Request $request)
    {

        $questionReplyId = $request->input('id');

        $questionReply = QuestionReply::findOrFail($questionReplyId);

        $questionReply->update([
            'reply' => $request->input('reply'),
        ]);

        return response()->json([
            'message' => 'questionReply updated'
        ]);
    }


    public function deleteFile(Request $request)
    {
        $fileId = $request->input('id');
        $file = Library::findOrFail($fileId);
        $file->delete();

        return response()->json([
            'message' => 'file deleted'
        ]);
    }


    public function updateFile(Request $request)
    {
        $validatedData = $request->validate([
            'file_url' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'title' => 'required|string|max:255',
            'type' => 'required|in:book,document',
        ]);

        $file = Library::findOrFail($request->input('id'));


        $updatedFileUrl = $request->file('file_url')->store('uploads');

        $file->file_url = $updatedFileUrl;
        $file->title = $validatedData['title'];
        $file->type = $validatedData['type'];
        $file->save();

        return response()->json(['message' => 'File updated']);
    }




    public function sendHomeworkOrLesson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'homework_name' => 'required|string',
            'type' => 'required|in:تسميع,واجب,درس مقرر',
            'notes' => 'required|string',
            'date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $classroom = Classroom::find($request->get('classroom_id'));

        if (!$classroom) {
            return response()->json(['errors' => ['classroom_id' => 'Invalid classroom ID']], 422);
        }

        $teacher = Teacher::find($request->get('teacher_id'));

        if (!$teacher) {
            return response()->json(['errors' => ['teacher_id' => 'Invalid teacher ID']], 422);
        }

        $subject = Subject::find($request->get('subject_id'));

        if (!$subject) {
            return response()->json(['errors' => ['subject_id' => 'Invalid subject ID']], 422);
        }

        $homework = new Homework([
            'classroom_id' => $classroom->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'homework_name' => $request->get('homework_name'),
            'type' => $request->get('type'), // Limit the type value to 50 characters
            'notes' => $request->get('notes'),
            'date' => $request->get('date'),
        ]);
        $homework->save();

        return response()->json([
            'message' => 'Homework or lesson sent successfully.',
            'data' => [
                'homework' => [
                    'id' => $homework->id,
                    'classroom_name' => $classroom->name,
                    'subject_name' => $subject->name,
                    'homework_name' => $homework->homework_name,
                    'type' => $homework->type,
                    'notes' => $homework->notes,
                    'date' => $homework->date,
                ],
            ],
        ], 201);
    }


    public function getClasses()
    {

        $classroom = \App\Models\Classroom::all();


        return response()->json($classroom);
    }




    public function getQuestionById(Request $request)
    {

        if (!auth()->guard('teacher')->check()) {
            return response()->json(['error' => 'Only teacher can view student consult.'], 403);
        }

        $questionId = $request->input('id');
        $question = Question::findOrFail($questionId);


        return response()->json([
                'id' => $question->id,
                'teacher_id' => $question->teacher_id,
                'student_id' => $question->student_id,
                'student_name' => $question->student->first_name.''.$question->student->last_name,
                'question' => $question->question,
                'answered' => $question->answered,
                'created_at' => $question->created_at,
                'updated_at' => $question->updated_at,

        ]);
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














    protected function createNewToken($token)
    {
        $user = auth()->guard('teacher')->user();
   $subject = $user->subject;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'subject_id'=>$user->subject_id,
                'monitor_id' => $user->monitor_id,
                'classroom_id' => $user->classroom_id,
                'department_id' => $user->department_id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'phone' => $user->phone,
                'image' => $user->image,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'full_name' => $user->first_name.' '.$user->last_name,
                'classroom_name' => $subject->classroom->name,
                'subject_name'=>$subject->name
            ],
        ]);
    }








}








































    /*public function sendHomeworkOrLesson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'homework_name' => 'required|string',
            'type' => 'required|in:   واجب , تسميع ,درس مقرر',
            'notes' => 'required|string',
            'date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $classroom = Classroom::find($request->get('classroom_id'));

        if (!$classroom) {
            return response()->json(['errors' => ['classroom_id' => 'Invalid classroom ID']], 422);
        }

        $teacher = Teacher::find($request->get('teacher_id'));

        if (!$teacher) {
            return response()->json(['errors' => ['teacher_id' => 'Invalid teacher ID']], 422);
        }

        $homework = new Homework([
            'classroom_id' => $classroom->id,
            'subject_id' => $request->get('subject_id'),
            'teacher_id' => $teacher->id,
            'homework_name' => $request->get('homework_name'),
            'type' => substr($request->get('type'), 0, 50), // Limit the type value to 50 characters
            'notes' => $request->get('notes'),
            'date' => $request->get('date'),
        ]);
        $homework->save();

        return response()->json([
            'message' => 'Homework or lesson sent successfully.',
            'data' => [
                'homework' => $homework,
            ],
        ], 201);
    }





//    public function replyToStudentQuestions(Request $request)
//    {
//        // التحقق من أن المستخدم هو معلم
//        if (!auth()->guard('teacher')) {
//            return response()->json(['error' => 'Only teachers can reply to student questions.'], 403);
//        }
//
//        // البحث عن جميع الأسئلة
//        $questions = Question::where('answered', false)->get();
//
//        // إنشاء رد جديد
//        $reply = new QuestionReply();
//        $reply->question_id = $request->input('question_id');
//        $reply->teacher_id =$request->input('teacher_id');
//        $reply->reply = $request->input('reply');
//        $reply->save();
//
//        // تحديث حالة السؤال إلى "تم الرد عليه"
//        $question = Question::findOrFail($request->input('question_id'));
//        $question->answered = true;
//        $question->save();
//
//
//        return response()->json(['message' => 'Reply saved successfully.']);
//    }
}

//    public function login(Request $request){
//    	$validator = Validator::make($request->all(), [
//            'first_name' => 'required',
//            'password' => 'required|string|min:6',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422);
//        }
//
//        if (! $token = auth()->guard('teacher')->attempt($validator->validated())) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//
//        return  $this->createNewToken($token);
//    }



//    public function uploadFile(Request $request)
//    {
//        $validatedData = $request->validate([
//            'title' => 'required|string',
//            'subject_id' => 'required|string',
//            'classroom_id' => 'required',
//            'type' => 'required|in:book,document',
//        ]);
//
//        $fileUpload = $request->file('file_url');
//        $file_url = $this->uploadImage($fileUpload, 'library');
//
//        $validatedData['teacher_id'] = auth()->guard('teacher')->user()->id;
//        $validatedData['file_url'] = $file_url;
//
//        $fileUploadRequest = Library::create($validatedData);
//
//        return response()->json('Uploaded successfully', $fileUploadRequest, 200);

/* public function sendHomeworkOrLesson(Request $request)
 {

     $validator = Validator::make($request->all(), [
     'classroom_id' => 'required|exists:classrooms,id',
     'subject_id' => 'required|exists:subjects,id',
     'title' => 'required|string',
     'type' => 'required|in:homework,lesson,recitation',
     'notes' => 'required|string',
     'date' => 'required|date'

     ]);

     if ($validator->fails()) {
         return response()->json(['errors' => $validator->errors()], 422);
     }

     $classroom = Classroom::find($request->get('classroom_id'));

     if (!$classroom) {
         return response()->json(['errors' => ['classroom_id' => 'Invalid classroom ID']], 422);
     }
     $teacher = Teacher::find($request->get('teacher_id'));

     if (!$teacher) {
         return response()->json(['errors' => ['teacher' => 'Invalid teacher']], 422);
     }
     $fullName = $teacher->first_name . ' ' . $teacher->last_name;


     $consultation = new Consult([
         'teacher_id' => $teacher->id,
         'classroom_id' => $classroom->id,
         'classroom_name' => $classroom->name,
         'subject_id'=>$classroom->subject_id,
         'subject_name' => $classroom->subject ? $classroom->subject->name : 'N/A',
         'note'=>$classroom->note,
         'date'=>$classroom->date,
         'type' => $request->get('type'),
         'student_id' => $request->get('student_id')
     ]);

     $consultation->save();

     return response()->json([
         'message' => 'Consultation request sent successfully.',
         'data' => [
             'consult' => $consultation,
             'teacher_full_name' => $fullName,
         ],
     ], 201);
 }/*
*/
