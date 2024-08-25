<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function all_students_report()
    {
        $department_id=Auth::user()->department_id;
        $class_students = Classroom::where('department_id',$department_id)
        ->with('students')
        ->get();
     
    
        $pdf = Pdf::loadView('reports.students', [
            'class_students' => $class_students
        ])->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('classes_students.pdf');
    }


    public function classroom_students_report(string $id)
    {
        $class_students = Classroom::where('id',$id)
        ->with('students')->get();
     
    
        $pdf = Pdf::loadView('reports.students', [
            'class_students' => $class_students
        ])->setOptions(['defaultFont' => 'Amiri,sans-serif']);


        
        return $pdf->download('class_students.pdf');
    }
    
    
    public function view_students(string $id)
    {
        $class_students = Classroom::where('id',$id)
        ->with('students')->get();
       // $attendences_absent=Attendance::where('attendance_status',0)->count();

    
     return view('reports.viewStudents',compact('class_students'));
    }

    // get all classrooms
    public function classrooms(){
        $classrooms=Classroom::all();
        return view('reports.classrooms',compact('classrooms'));
    }

}
