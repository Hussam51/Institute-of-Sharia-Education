<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;

class QuizController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $quizzes=Quiz::all();
       return view('Quizzes.index',compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $department_id=Auth::user()->department_id;
      
        $classrooms=Classroom::where('department_id',$department_id)->get();
        $subjects=Subject::all();
        return view('Quizzes.create',compact('classrooms','subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // dd($request->all());
        $validatedData = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'min_mark' => 'numeric|required',
            'max_mark' => 'numeric|required',
            'type' => 'required',
           
        ]);
       $validatedData['department_id']=Auth::user()->department_id;
       Quiz::create($validatedData);
       Toastr::success('Created Successfully','Quiz');
       return redirect()->route('dashboard.quizzes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
      
        return view('Quizzes.show',compact('quiz'));

    }

    public function class_subjects(string $id){
    
        $class_subjects = Subject::where('classroom_id', $id)->get(['id','name']);
      
        return $class_subjects;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $department_id=Auth::user()->department_id;
        $classrooms= Classroom::where('department_id',$department_id)->get();
        $subjects=Subject::all();
        return view('Quizzes.edit',compact('quiz','classrooms','subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validatedData = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'min_mark' => 'numeric|required',
            'max_mark' => 'numeric|required',
            'type' => 'required',
           
        ]);
      
       $quiz->update($validatedData);
       Toastr::success('Updated Successfully','Quiz');
       return redirect()->route('dashboard.quizzes.index');
    }

    public function quiz_marks(Request $request,string $classroom_id,string $quiz_id){
        $quiz=Quiz::where('id',$quiz_id)->first();
        $marks=$quiz->marks;
        return view('QuizResults.show',compact('marks'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
       $quiz->delete();
       toastr('Quiz Deleted Successfully','warning','Success');
       return redirect()->route('dashboard.quizzes.index');
    }
}
