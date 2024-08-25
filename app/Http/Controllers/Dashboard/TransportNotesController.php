<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\StudentTransport;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $busNotes=StudentTransport::all();
       return view('Notes.index',compact('busNotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transports=Transport::all();
        $classrooms=Classroom::where('department_id',Auth::user()->department_id)
        ->get();
        return view('Notes.create',compact('transports','classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

           
            'note' => 'required|string',
            'student_id' => 'required',
            'status' => 'required',
            'transport_id'=>'required',
            'date'=>'required'
        ]);
        $student= Student::findOrFail($request->student_id)->first();
        $validatedData['parent_id'] = $student->parent->id;
       
        StudentTransport::create($validatedData);
        Toastr(' transport note  added successfully','success','Transport Notes');
        return redirect()->route('dashboard.bus_notes.index');
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
        $studentTrans=StudentTransport::findOrFail($id)->first();
        $transports =Transport::all();
        return view('Notes.edit',compact('studentTrans','classrooms','transports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $studentTrans=StudentTransport::findOrFail($id);
        $validatedData = $request->validate([

           
            'note' => 'required|string',
            'status' => 'required',
            'transport_id'=>'required',
            'date'=>'required'

        ]);
        if($request->has('student_id')){
            $student= Student::findOrFail($request->student_id)->first();
            $validatedData['student_id'] = $student->id;
            $validatedData['parent_id'] = $student->parent->id;
        }
      
        $studentTrans->update($validatedData);

        Toastr(' transport note  updated successfully','info','Transport Notes');
        return redirect()->route('dashboard.bus_notes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        StudentTransport::findOrFail($id)
        ->delete();

        Toastr(' transport note  deleted successfully','warning','Transport Notes');
        return redirect()->route('dashboard.bus_notes.index');
    }
}
