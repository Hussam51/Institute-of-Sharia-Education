<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class ReportsController extends Controller
{
    public function all_students_report()
    {
        $class_students = Classroom::with('students')->get();
     
    
     
    
        $pdf = Pdf::loadView('reports.students', [
            'class_students' => $class_students
        ])->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('classes_students.pdf');
    }


    public function classroom_students_report(string $id)
    {
        $class_students = Classroom::find($id)
        ->with('students')->get();
     
    
     
    
        $pdf = Pdf::loadView('reports.students', [
            'class_students' => $class_students
        ])->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('class_students.pdf');
    }
    
    
    public function view_students(string $id)
    {
        $class_students = Classroom::find($id)
        ->with('students')->get();
     
    
     return view('reports.viewStudents',compact('class_students'));
    }

    // get all classrooms
    public function classrooms(){
        $classrooms=Classroom::all();
        return view('reports.classrooms',compact('classrooms'));
    }

}
