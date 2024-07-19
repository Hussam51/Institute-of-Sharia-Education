<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Note;
use App\Models\ParentFeedback;
use App\Models\Parents;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $behaviors=Note::all();
        return view('behaviorStudents.index',compact('behaviors'));
    }


    public function parentFeedback()
    {
        $parent_notes=ParentFeedback::all();
        return view('Notes.parentNotes',compact('parent_notes'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms=Classroom::all();
       return view('behaviorStudents.create',compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

           
            'note' => 'required|string',
            'student_id' => 'required',
            'type' => 'required|in:positive,negative',

        ]);
        $student= Student::findOrFail($request->student_id)->first();
        $validatedData['parent_id'] = $student->parent->id;
        $validatedData['admin_id'] = Auth::user()->id;
        $validatedData['sent_by'] = Auth::user()->name;
        Note::create($validatedData);
        Toastr(' student behavoir added successfully','success','behavoir');
        return redirect()->route('dashboard.behaviors.index');
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
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)
               ->get();
        $behavoir=Note::findOrFail($id)->first();
        return view('behaviorStudents.edit',compact('behavoir','classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $behavoir=Note::findOrFail($id);
        $validatedData = $request->validate([

           
            'note' => 'required|string',
            'student_id' => 'required',
            'type' => 'required|in:positive,negative',

        ]);
        if($request->has('student_id')){
            $student= Student::findOrFail($request->student_id)->first();
            $validatedData['student_id'] = $student->id;
            $validatedData['parent_id'] = $student->parent->id;
        }
      
        $behavoir->update($validatedData);

        Toastr(' student behavoir updated successfully','info','behavoir');
        return redirect()->route('dashboard.behaviors.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Note::findOrFail($id)
        ->delete();

        Toastr(' student behavoir deleted successfully','warning','behavoir');
        return redirect()->route('dashboard.behaviors.index');
        
    }
}
