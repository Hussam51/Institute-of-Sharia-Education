<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\storeSubjectRequest;
use App\Http\Requests\Subjects\updateSubjectRequest;
use App\Models\Classroom;
use App\Models\Subject;
use App\Repositories\Subject\SubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects=Subject::all();
        $department_id=Auth::user()->department_id;
        $classrooms=Classroom::where('department_id',$department_id)->get();
      return view('Subjects.subject',compact('subjects','classrooms'));
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
    public function store(SubjectRepository $subjectRepository,storeSubjectRequest $request)
    {

        try{
         $subjectRepository->add($request);
         toastr('created successfully','success');
         return redirect()->route('dashboard.subjects.index');
      }
      catch(Exception $e){
        return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
      }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRepository $subjectRepository,updateSubjectRequest $request,Subject $subject)
    {
        try {
            $subjectRepository->update($request, $subject);
           
            return redirect()->route('dashboard.subjects.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors("success", $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
       $subject->delete();
       toastr('deleted successfully','warning','Deleted');
       return redirect()->route('dashboard.subjects.index');
    }
}
