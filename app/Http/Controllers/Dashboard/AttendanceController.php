<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::all();
        return view('Attendances.classrooms', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {

            foreach ($request->attendances as $student_id => $attendance) {


                if ($attendance == 'presence') {
                    $attendance_status = 'حاضر';
                    
                } else if ($attendance == 'absent') {

                    $attendance_status = 'غياب';
                }
                else if ($attendance == 'late') {

                    $attendance_status = 'تأخر';
                }

                $validatedData =[
                    'student_id' => $student_id,
                    'department_id' => $request->department_id,
                    'classroom_id' => $request->classroom_id,

                    'attendance_date' => date('Y-m-d'),
                    'attendance_status' => $attendance_status
                ];

                if ($attendance == 'absent' && $request->has('absent_reason') ) {
                    $validatedData['absent_reason'] = $request->absent_reason;
                }
                Attendance::create($validatedData);
            }

            toastr()->success('attecndences added successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $classroom = Classroom::find($id)->first();
        $students = Student::where('classroom_id', $id)->with('attendances')->get();
        return view('Attendances.classAttendances', compact('students', 'classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
