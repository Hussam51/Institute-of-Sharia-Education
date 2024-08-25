<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherMonitoringTable;
use App\Models\TeacherWeekTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherWeekTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)->get();
        $teachersTimes=TeacherWeekTimes::all();
        return view('TeacherWeekTable.index',compact('teachersTimes','classrooms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)->get();
        return view('TeacherWeekTable.create',compact('classrooms'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([

             'day'=>'required',
            'classroom_id' => 'required',
            'teacher_id' => 'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ]);
       
       // $teacher=Teacher::findOrFail($request->teacher_id);
      //  $validatedData['subject_id']=$teacher->subject_id;
      TeacherWeekTimes::create($validatedData);
        Toastr(' Time Table  added successfully','success','Time Table  ');
        return redirect()->route('dashboard.teacher_weekTable.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)->get();
       
        $teacherTime=TeacherWeekTimes::findOrFail($id);
        return view('TeacherWeekTable.edit',compact('teacherTime','classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $homework=TeacherWeekTimes::findOrFail($id);
        $validatedData = $request->validate([

            'day'=>'required',
            'classroom_id' => 'required',
            'teacher_id' => 'required',
            'start_time'=>'required',
            'end_time'=>'required',

        ]);
     /*   if($request->has('teacher_id')){
            $teacher=Teacher::findOrFail($request->teacher_id);
            $validatedData['subject_id']=$teacher->subject_id;
        }
      */
        $homework->update($validatedData);

        Toastr(' Time Table updated successfully','success','Time Table ');
        return redirect()->route('dashboard.teacher_weekTable.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homework =TeacherWeekTimes::findOrFail($id)
        ->delete();

        Toastr('Time Table deleted successfully!','warning');
        return redirect()->route('dashboard.teacher_weekTable.index');
    }
}
