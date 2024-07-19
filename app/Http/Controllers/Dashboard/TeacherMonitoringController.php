<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherMonitoringTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherMonitoringController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers=Teacher::all();
        $monitorings=TeacherMonitoringTable::all();
        return view('TeacherMonitoring.index',compact('monitorings','teachers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // $classrooms=Classroom::where('department_id',Auth::user()->department_id)->get();
        $teachers=Teacher::all();
        return view('TeacherMonitoring.create',compact('teachers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'hall' => 'required',
            'teacher_id' => 'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'date'=>'required',
            
        ]);
       
       
        TeacherMonitoringTable::create($validatedData);
        Toastr(' Monitoring  added successfully','success','Monitoring ');
        return redirect()->route('dashboard.teacher_monitorings.index');
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
      
        $teachers=Teacher::all();
        $monitoring=TeacherMonitoringTable::findOrFail($id);
        return view('TeacherMonitoring.edit',compact('monitoring','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $monitoring=TeacherMonitoringTable::findOrFail($id);
        $validatedData = $request->validate([

           
            'hall' => 'required',
            'teacher_id' => 'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'date'=>'required',

        ]);
       
        $monitoring->update($validatedData);

        Toastr(' monitoring updated successfully','success','Monitoring ');
        return redirect()->route('dashboard.teacher_monitorings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homework =TeacherMonitoringTable::findOrFail($id)
        ->delete();

        Toastr('Monitoring question deleted successfully!','warning');
        return redirect()->route('dashboard.teacher_monitorings.index');
    }
}
