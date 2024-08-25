<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::where('department_id',Auth::user()->department_id)->get();
        return view('Teachers.attendences', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //     return view('reports.viewStudents',compact('class_students'));

    }

    public function report()
    {
        $teachers=Teacher::where('department_id',Auth::user()->department_id)->get();
            return view('Teachers.report',compact('teachers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {

            foreach ($request->attendances as $teacher_id => $attendance) {


                if ($attendance == 'presence') {
                    $attendance_status = 1;
                    
                } else if ($attendance == 'absent') {

                    $attendance_status = 0;
                }
               
                $validatedData =[
                    'teacher_id' => $teacher_id,

                    'attendance_date' => date('Y-m-d'),
                    'attendance_status' => $attendance_status
                ];

              
                TeacherAttendance::create($validatedData);
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
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherAttendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherAttendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherAttendance $attendance)
    {
        //
    }
}
