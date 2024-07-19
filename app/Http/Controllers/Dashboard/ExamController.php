<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Exam;
use Exception;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms=Classroom::all();
        return view('ExamTables.classrooms',compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            foreach ($request->list_classes as $list_class) {
            
               $list= Exam::create($list_class);
              
            }
            toastr()->success('created successfully');
            return redirect()->route('dashboard.exam_tables.show',$request->classroom_id);

        } catch (Exception $e) {
           return redirect()->back()->withErrors("Warning", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
       $classroom=Classroom::where('id',$id)->first();
      
       $tables=Exam::where('classroom_id',$id)->get();
       $subjects=$classroom->subjects;
       return view('ExamTables.index',compact('tables','classroom','subjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $exam= Exam::findOrfail($id);
          $classId=$exam->classroom->id;
          $exam->delete();
          toastr()->warning('Deleted Successfully');
        return redirect()->route('dashboard.exam_tables.show',$classId);
    }
}
