<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Adviser;
use App\Models\Attendance;
use App\Models\Consult;
use App\Models\Exam;
use App\Models\Note;
use App\Models\ParentFeedback;
use App\Models\Parents;
use App\Models\Student;
use App\Models\StudentTransport;
use App\Models\Subject;
use App\Models\Transport;
use App\Models\WeekTable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
class ParentController extends Controller
{
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

        $credentials = $validator->validated();

        if (!$token = auth()->guard('parent')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }



        return $this->createNewToken($token);




    }


    public function showStudentProfile(Request $request)
    {

        $parent = auth()->guard('parent')->user();

        if (!$parent) {
            return response()->json(['error' => 'غير مصرح لك بالوصول إلى هذا الملف الشخصي'], 403);
        }

        $studentId = $request->input('student_id');

        $student = $parent->student()->find($studentId);

        if (!$student) {
            return response()->json(['error' => 'لا يوجد طالب بهذا المعرف'], 404);
        }
        if (str_contains($student->classroom->name, 'بكالوريا') ||
            str_contains($student->classroom->name, 'عاشر') ||
            str_contains($student->classroom->name, 'حادي عشر')) {
            $education_stage = 'ثانوي';
        } elseif (str_contains($student->classroom->name, 'سادس')||
            str_contains($student->classroom->name, 'سابع') ||
            str_contains($student->classroom->name, ' ثامن')||
            str_contains($student->classroom->name, 'تاسع')) {
            $education_stage = 'إعدادي';
        }
        elseif (str_contains($student->classroom->name, 'اول')||
            str_contains($student->classroom->name, 'ثاني') ||
            str_contains($student->classroom->name, ' ثالث')||
            str_contains($student->classroom->name, 'رابع')||
            str_contains($student->classroom->name, 'خامس')) {
            $education_stage = 'ابتدائي';
        } else {
            $education_stage = null;
        }

        $userData = $student->toArray();
        $userData['education_stage'] = $education_stage;

        return response()->json($userData);

    }


    public function logout()
    {
        auth()->guard('parent')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function getStudentNotes1(Request $request)
    {
        $studentId = $request->input('student_id');
        if (!$studentId) {
            return response()->json(['errors' => ['student_id' => 'Invalid student ID']], 422);
        }
        $student = Student::with('notes')->find($studentId);
        return response()->json($student->notes);
    }




    public function getAllTransport()
    {
        $transportationSchedules = Transport::all();

        return response()->json($transportationSchedules);
    }






/////////////////////////////////


    public function showBusNotes(Request $request)
    {
        $studentId = $request->input('student_id');

        $studentTransports = StudentTransport::where('student_id', $studentId)
            ->with('transport', 'parent')
            ->orderByDesc('date')
            ->get();

        $notesWithDetails = $studentTransports->map(function ($transport) {
            return [
                'transport' => $transport->transport->route_name,
                'parent' => $transport->parent ? $transport->parent->firstname.''.$transport->parent->last_name : null,
                'status' => $transport->status,
                'note' => $transport->note,
                'date' => Carbon::parse($transport->date)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'student' => [
                'id' => $studentId,
            ],
            'bus_notes' => $notesWithDetails,
        ]);
    }


////////////////////////////////////////////

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







    public function showTransportById(Request $request)
    {
        $id = $request->input('id');
        $transportationSchedule = Transport::findOrFail($id);

        return response()->json($transportationSchedule);
    }




    public function showTransportByTimeOrLocation(Request $request)
    {
        $departureLocation = $request->input('departure_location');
        $departureTime = $request->input('departure_time');

        $transportationSchedules = Transport::query();

        if ($departureLocation) {
            $transportationSchedules->where('start_location', $departureLocation);
        }

        if ($departureTime) {
            $transportationSchedules->where('departure_time', '>=', $departureTime);
        }

        $transportationSchedules = $transportationSchedules->get();

        return response()->json($transportationSchedules);
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

        // Fetch the student's total score
        $totalScore = $student->rates()->sum('score');

        // Return the response
        return response()->json([
            'evaluations' => $evaluationData,
            'total_score' => $totalScore,
        ]);
    }


    public function showStudentAttendance(Request $request)
    {
        $studentId = $request->input('student_id');
        $classroomId = $request->input('classroom_id');
        $absent_reason= $request->input('absent_reason');
        $attendance = Attendance::where('student_id', $studentId)
            ->where('classroom_id', $classroomId)
            ->orderBy('attendance_date', 'desc')
            ->get();


        $attendanceSummary = [
            'حاضر' => $attendance->where('attendance_status', 'حاضر')->count(),
            'تأخر' => $attendance->where('attendance_status', 'تأخر')->count(),
            'غياب' =>[
              'مبرر'=>   $attendance->where('attendance_status', 'غياب')->whereNotNull($absent_reason)->count(),
              'غير مبرر'=> $attendance->where('attendance_status', 'غياب')->whereNull($absent_reason)->count(),
            ]
,
///////////////////////////تعديل

        ];

        return response()->json([
            'attendance' => $attendance,
            'summary' => $attendanceSummary,
        ]);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////المودل

    public function sendNote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|exists:parents,id',
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $parent = Parents::find($request->get('parent_id'));
        if (!$parent) {
            return response()->json(['errors' => ['parent' => 'Invalid student']], 422);
        }

        $admins = Admin::all(); /////////////////////////////////////////////////////////

        foreach ($admins as $admin) {
            $note = new ParentFeedback([
                'parent_id' => $parent->id,
                'admin_id' => $admin->id,
                'note' => $request->note,
                'sent_at' => now(),
                'status' => 'pending',
            ]);

            $note->save();
        }

        return response()->json([
            'message' => 'note sent successfully.',
        ], 201);
    }




    public function getAllSentNotes()
    {
        $note = ParentFeedback::all();

        return response()->json($note);
    }


    public function deleteNotes(Request $request)
    {
        $noteId = $request->input('id');
        $note = ParentFeedback::findOrFail($noteId);
        $note->delete();

        return response()->json([
            'message' => 'Note deleted'
        ]);
    }


    public function updateNotes(Request $request)
    {

        $noteId = $request->input('id');

        $note = ParentFeedback::findOrFail($noteId);

        $note->update([
            'note' => $request->input('note'),
        ]);

        return response()->json([
            'message' => 'Note updated'
        ]);
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

        return response()->json([
            'subjects' => $subjects
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







    protected function createNewToken($token)
    {
        $user = auth()->guard('parent')->user();
        $student = $user->student;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'admin_id' => $user->admin_id,
                'student_id' => $student->id,
                'password' => $user->password,
                'phone' => $user->phone,
                'image' => $user->image,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'student_name' => $student->first_name.' '.$student->last_name,
                'classroom_id' => $student->classroom_id,
                'classroom_name' => $student->classroom->name,
            ],
        ]);
    }

}














    /*public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'student_id' => 'required|integer',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $parent = Parents::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->first();

        if ($parent && $parent->student_id == $request->student_id) {
            if (Hash::check($request->password, $parent->password)) {
                return $this->createNewToken($parent);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }*/

//    public function login(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'student_id' => 'required|integer',
//            'password' => 'required|string|min:6',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422);
//        }
//
//        $parent = Parents::where('first_name', $request->first_name)
//            ->where('last_name', $request->last_name)
//            ->first();
//
//        if ($parent && $parent->student_id == $request->student_id) {
//            $student = $parent->student()->where('id', $request->student_id)->first();
//
//            if ($student && Hash::check($request->password, $student->password)) {
//                $token = $this->createNewToken($student);
//                return response()->json(['token' => $token], 200);
//            } else {
//                return response()->json(['error' => 'Unauthorized'], 401);
//            }
//        } else {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//    }


//






//    public function login(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'student_id' => 'required|integer',
//            'password' => 'required|string|min:6',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422);
//        }
//
//        $parent = Parents::where('first_name', $request->first_name)
//            ->where('last_name', $request->last_name)
//            ->first();
//
//        if ($parent && $parent->student()->where('id', $request->student_id)->exists()) {
//            if (Hash::check($request->password . 'p', $parent->password)) {
//                return $this->createNewToken($parent);
//            } else {
//                return response()->json(['error' => 'Unauthorized'], 401);
//            }
//        } else {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//    }
/*public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $password = $request->password;
    $passwordWithSuffix = $password . 'p';

    if (auth()->guard('parent')->attempt([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'password' => $passwordWithSuffix]))
    {
        return $this->createNewToken(auth()->guard('parent')->user());
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
*/




//  public function getBusNote()
//    {
//        $busNotes = StudentTransport::all();
//        return response()->json($busNotes);
//    }







//    public function getStudentNotes(Request $request)
//    {
//        // Validate the student ID
//        $validator = Validator::make(['student_id' => $request->get('student_id')], [
//            'student_id' => 'required|integer',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['error' => 'Invalid student ID'], 400);
//        }
//
//        // Fetch the student's notes
//        $student = Student::find($request->get('student_id'));
//
//        if (!$student) {
//            return response()->json(['error' => 'Student not found'], 404);
//        }
//
//        $notes = $student->notes()->orderByDesc('sent_at')->get();
//
//        // Map the notes to an array with the necessary data
//        $noteData = $notes->map(function ($note) {
//            return [
//                'id' => $note->id,
//                'note' => $note->note,
//                'sent_by' => $note->sent_by,
//                'sent_at' => $note->sent_at,
//            ];
//        });
//
//        // Return the response
//        return response()->json([
//            'notes' => $noteData,
//        ]);
//    }







