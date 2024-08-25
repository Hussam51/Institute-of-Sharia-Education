<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department_id=Auth::user()->department_id;
        $classrooms=Classroom::Where('department_id',$department_id)->get();
        return view('WeekTables.classrooms',compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
    
        //  $classrooms=Classroom::where('department_id',$department_id)->get();
       // $subjects=Subject::all();
      //return view('QuizResults.create',compact('classrooms','subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'student_id' => 'required|exists:students,id',
            'student_mark' => 'numeric|required',
           
           
        ]);
      
       Mark::create($validatedData);
       Toastr::success('Created Successfully','Mark');
       return redirect()->route('dashboard.quiz_results.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
     
        $classroom=Classroom::find($id);
        $quizzes=Quiz::get();// يجب معالجتها
        $students=$classroom->students;
      
        $marks=Mark::all();
        return view('QuizResults.index',compact('quizzes','classroom','students','marks'));

    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mark $mark)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'student_id' => 'required|exists:students,id',
            'student_mark' => 'numeric|required',
           
           
        ]);
      
       Mark::find($id)->update($validatedData);
       Toastr::success('Updated Successfully','Mark');
       return redirect()->route('dashboard.quiz_results.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Mark::find($id)->delete();
    
       toastr('Mark Deleted Successfully','warning','Success');
       return redirect()->route('dashboard.quiz_results.index');
    }
}
