<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Homework;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)->get();

        $homeworks=Homework::all();
        return view('Homeworks.index',compact('homeworks','classrooms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)->get();
        $subjects=Subject::all();
        return view('Homeworks.create',compact('classrooms','subjects'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

           
            'notes' => 'nullable|string',
            'homework_name' => 'string',
            'classroom_id' => 'required',
            'teacher_id' => 'required',
            'subject_id'=>'required',
            'date'=>'required',
            'type'=>'required',
        ]);
       
       
        Homework::create($validatedData);
        Toastr(' homework  added successfully','success','homework ');
        return redirect()->route('dashboard.homeworks.index');
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
        $subjects=Subject::all();
        $homework=Homework::findOrFail($id)->first();
        return view('Homeworks.edit',compact('homework','classrooms','subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $homework=Homework::findOrFail($id);
        $validatedData = $request->validate([

           
            'notes' => 'nullable|string',
            'homework_name' => 'string',
            'classroom_id' => 'required',
            'teacher_id' => 'required',
            'subject_id'=>'required',
            'date'=>'required',
            'type'=>'required',

        ]);
       
        $homework->update($validatedData);

        Toastr(' homework updated successfully','success','homework ');
        return redirect()->route('dashboard.homeworks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homework =Homework::findOrFail($id)
        ->delete();

        Toastr('Entertainment question deleted successfully!','warning');
        return redirect()->route('dashboard.homeworks.index');
    }
}
