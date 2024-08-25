<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class MentorController extends Controller
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

        if (!$token = auth()->guard('monitor')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->createNewToken($token);
    }








    public function logout()
    {
        auth()->guard('monitor')->logout();

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



    public function showStudent(Request $request)
    {
        // Check if the user is an authorized monitor
        if (!auth()->guard('monitor')->check()) {
            return response()->json(['error' => 'Only mentor can view student attendance.'], 403);
        }

        $classroomId = $request->input('classroom_id');

        if (is_string($classroomId) && is_numeric($classroomId)) {
            // Get the authenticated adviser
            $adviser = auth()->guard('monitor')->user();

            // Fetch the students in the specified classroom
            $attendance = Student::where('classroom_id', $classroomId)->get();

            return response()->json([
                'check_list_Attendance' => $attendance
            ]);
        } else {
            return response()->json([
                'error' => 'Invalid classroom ID'
            ], 400);
        }
    }



/////////////////////////////////////////////////////
    public function markAttendance(Request $request)
    {
        if (!auth()->guard('monitor')->check()) {
            return response()->json(['error' => 'Only mentor can mark student attendance.'], 403);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'department_id' => 'required|exists:departments,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'attendance_status' => 'required|in:تأخر,حاضر,غياب',
            'attendance_date' => 'required|date',
        ]);

        $student = Student::findOrFail($request->student_id);
        $classroom = Classroom::findOrFail($request->classroom_id);

        // التحقق من وجود سجل حضور مسبق للطالب في نفس اليوم والصف
        $existingAttendance = $student->attendances()
            ->where([
                'classroom_id' => $request->classroom_id,
                'attendance_date' => $request->attendance_date,
            ])
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'error' => 'تم تسجيل حضور الطالب مسبقًا في هذا اليوم والصف'
            ], 400);
        }

        $attendance = $student->attendances()->create([
            'classroom_id' => $request->classroom_id,
            'attendance_status' => $request->attendance_status,
            'attendance_date' => $request->attendance_date,
            'department_id' => $request->department_id,
        ]);

        return response()->json([
            'message' => 'تم حفظ بيانات الحضور بنجاح',
            'attendance' => $attendance
        ], 201);
    }












    public function QRmarkAttendanceForTeacher(Request $request)
    {
        $teacherId = $request->input('teacher_id');

        $attendance = TeacherAttendance::firstOrCreate([
            'teacher_id' => $teacherId,
            'created_at' => now(),
        ]);

        $attendance->attendance_status = 1;
        $attendance->save();

        return response()->json([
            'message' => 'Attendance marked successfully.',
            'attendance' => $attendance
        ], 200);
    }








    public function checkTeacherAttendance(Request $request)
    {
        // Validate the input parameters
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $teacherId = $request->input('teacher_id');

        // Check if the teacher is assigned to the classroom
        $isTeacherAssigned = Teacher::where('id', $teacherId)

            ->exists();

        if (!$isTeacherAssigned) {
            return response()->json([
                'message' => 'هذا المعلم غير مخصص لتدريس هذا الصف'
            ], 400);
        }

        // Check if the teacher has already marked attendance for the day
        $attendance = TeacherAttendance::where('teacher_id', $teacherId)
            ->where('attendance_date', date('Y-m-d'))
            ->first();

        if ($attendance && $attendance->attendance_status) {
            // Retrieve the teacher information
            $teacher = Teacher::find($teacherId);

            return response()->json([
                'message' => 'تم تسجيل حضور هذا المعلم مسبقًا',
                'teacher' => [
                    'id' => $teacher->id,
                    'first_name' => $teacher->first_name,
                    'last_name' => $teacher->last_name,
                    'phone' => $teacher->phone,
                    'email' => $teacher->email,
                    'image' => $teacher->image,
                ],
                'attendance' => [
                    'attendance_date' => $attendance->attendance_date,
                    'attendance_status' => $attendance->attendance_status,
                ]
            ], 200);
        }

        // Create a new attendance record or update the existing one
        if ($attendance) {
            $attendance->attendance_status = true;
            $attendance->save();
        } else {
            $attendance = TeacherAttendance::create([
                'teacher_id' => $teacherId,
                'attendance_date' => date('Y-m-d'),
                'attendance_status' => true
            ]);
        }

        // Retrieve the teacher information
        $teacher = Teacher::find($teacherId);

        return response()->json([
            'message' => 'تم تسجيل حضور المعلم بنجاح',
            'teacher' => [
                'id' => $teacher->id,
                'first_name' => $teacher->first_name,
                'last_name' => $teacher->last_name,
                'phone' => $teacher->phone,
                'email' => $teacher->email,
                'image' => $teacher->image,
            ],
            'attendance' => [
                'attendance_date' => $attendance->attendance_date,
                'attendance_status' => $attendance->attendance_status,
            ]
        ], 201);
    }




    public function getClasses()
    {

        $classroom = \App\Models\Classroom::all();


        return response()->json($classroom);
    }



/*

    public function checkAttendance(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'attendance_date' => 'required|date',
        ]);

        $attendance = TeacherAttendance::where('teacher_id', $validated['teacher_id'])
            ->whereDate('attendance_date', $validated['attendance_date'])
            ->first();

        if ($attendance) {
            // Update existing attendance record
            $attendance->update([
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Attendance updated.',
                'attendance' => $attendance
            ], 200);
        } else {
            // Create new attendance record
            $attendance = TeacherAttendance::create([
                'teacher_id' => $validated['teacher_id'],
                'attendance_date' => $validated['attendance_date'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Attendance recorded.',
                'attendance' => $attendance
            ], 201);
        }
    }
*/

//
//    public function checkAttendance(Request $request)
//    {
//        $validated = $request->validate([
//            'teacher_id' => 'required|exists:teachers,id',
//            'attendance_date' => 'required|date',
//        ]);
//
//        $attendance = TeacherAttendance::create([
//            'teacher_id' => $validated['teacher_id'],
//            'attendance_date' => $validated['attendance_date'],
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
//
//        return response()->json([
//            'message' => 'Attendance recorded.',
//            'attendance' => $attendance
//        ], 201);
//    }






    /*public function checkAttendance(Request $request)
    {
        $teacherId = $request->input('teacher_id');

        $attendance = TeacherAttendance::where('teacher_id', $teacherId)
            ->whereDate('created_at', date('Y-m-d'))
            ->first();

        if ($attendance) {
            return response()->json([
                'message' => 'Attendance found.',
                'attendance' => $attendance
            ], 200);
        } else {
            return response()->json([
                'message' => 'Attendance not found.',
                'attendance' => $attendance
            ], 404);
        }
    }*/






//
//
//    public function QRmarkAttendanceForTeacher(Request $request)
//    {
//        $teacherId = $request->input('teacher_id');
//        $attendance = TeacherAttendance::where('teacher_id', $teacherId)
//            ->whereDate('created_at', date('Y-m-d'))
//            ->first();
//
//        if ($attendance) {
//            return $attendance->attendance_status;
//        } else {
//            $attendance = TeacherAttendance::create([
//                'teacher_id' => $teacherId,
//                'attendance_status' => 0,
//                'created_at' => now(),
//            ]);
//
//            return $attendance->attendance_status;
//        }
//    }





/*
    public function QRmarkAttendanceForTeacher(Request $request)
    {
        $teacherId = $request->input('teacher_id');

        // Check if attendance already marked for the teacher
        $attendance = DB::table('teacher_attendance')
            ->where('teacher_id', $teacherId)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if ($attendance) {
            return response()->json([
                'message' => 'Attendance already marked for the teacher.'
            ], 400);
        }

        // Mark attendance
        DB::table('teacher_attendance')->insert([
            'teacher_id' => $teacherId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Attendance marked successfully.'
        ], 200);
    }

*/




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
        $user = auth()->guard('monitor')->user();
      //  $student = $user->student;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'password' => $user->password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'full_name' => $user->first_name.' '.$user->last_name,

            ],
        ]);
    }
}












































/*  public function markAttendance(Request $request)
  {

      // Check if the user is an authorized monitor
      if (!auth()->guard('monitor')->check()) {
          return response()->json(['error' => 'Only mentor can mark student attendance.'], 403);
      }

      $classroomId = $request->input('classroom_id');

      $classroom = Classroom::findOrFail($classroomId);

      $students = $classroom->students;

      foreach ($students as $student) {
          $attendance = Attendance::where('student_id', $student->id)
              ->where('classroom_id', $classroom->id)
              ->where('attendance_date', now()->format('Y-m-d'))
              ->first();

          if ($attendance) {
              // Check if the student is present
              if ($student->ispresent($classroom->id, now()->format('Y-m-d'))) {
                  $attendance->attendance_status = 'حاضر';
              } else {
                  $attendance->attendance_status = 'غياب';
              }
              $attendance->save();
          } else {
              $attendance = new Attendance([
                  'student_id' => $student->id,
                  'classroom_id' => $classroom->id,
                  'department_id' => $classroom->department->id,
                  'attendance_date' => now()->format('Y-m-d'),
                  'attendance_status' => $student->ispresent($classroom->id, now()->format('Y-m-d')) ? 'حاضر' : 'غياب',
              ]);
              $attendance->save();
          }
      }

      return response()->json([
          'message' => 'Attendance marked successfully',
        //  $attendance
      ], 200);
//    }*/
//
//    public function markAttendance(Request $request)
//    {
//        $studentId = $request->input('student_id');
//        $classroomId = $request->input('classroom_id');
//        $attendanceDate = $request->input('attendance_date');
//
//        $student = Student::findOrFail($studentId);
//        $isPresent = $student->ispresent($classroomId, $attendanceDate);
//
//        return response()->json([
//            'is_present' => $isPresent
//        ]);
//    }
//
//    public function ispresent($classroomId, $attendanceDate)
//    {
//        $attendance = Attendance::where('student_id', $this->id)
//            ->where('classroom_id', $classroomId)
//            ->where('attendance_date', $attendanceDate)
//            ->first();
//
////        return $attendance && $attendance->attendance_status == 'حاضر';
////    }
//    public function markAttendance(Request $request)
//    {
//        $studentId = $request->input('student_id');
//        $classroomId = $request->input('classroom_id');
//        $attendanceDate = $request->input('attendance_date');
//        $student = Student::findOrFail($studentId);
//
//        $attendance = Attendance::where('student_id', $student)
//            ->where('classroom_id', $classroomId)
//            ->where('attendance_date', $attendanceDate)
//            ->first();
//
//        $isPresent = $attendance ? $attendance->is_present : false;
//
//        return [
//            'student_id' => $student,
//            'classroom_id' => $classroomId,
//            'attendance_date' => $attendanceDate,
//            'is_present' => $isPresent
//        ];
//    }
//
//    public function markAttendance(Request $request)
//    {
//        // Check if the user is an authorized monitor
//        if (!auth()->guard('monitor')->check()) {
//            return response()->json(['error' => 'Only mentor can mark student attendance.'], 403);
//        }
//
//        $classroomId = $request->input('classroom_id');
//
//        $classroom = Classroom::findOrFail($classroomId);
//
//        $students = $classroom->students;
//
//        foreach ($students as $student) {
//            $attendance = Attendance::where('student_id', $student->id)
//                ->where('classroom_id', $classroom->id)
//                ->where('attendance_date', now()->format('Y-m-d'))
//                ->first();
//
//            if ($attendance) {
//                $attendance->attendance_status = 'present';
//                $attendance->save();
//            } else {
//                $attendance = new Attendance([
//                    'student_id' => $student->id,
//                    'classroom_id' => $classroom->id,
//                    'department_id' => $classroom->department->id,
//                    'attendance_date' => now()->format('Y-m-d'),
//                    'attendance_status' => 'present',
//                ]);
//                $attendance->save();
//            }
//        }
//
//        return response()->json([
//            'message' => 'Attendance marked successfully',
//        ], 200);
//    }
