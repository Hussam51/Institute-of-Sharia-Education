<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Parents;
use App\Models\Student;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       
        $parents = Parents::with('student')->get();
       
        return view('Parents.index', compact('parents'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('Parents.create', compact('departments'));
    }



public function class_students(string $id){
    
    $class_students = Student::where('classroom_id', $id)->get(['id','last_name','first_name']);
  
    return $class_students;
}



public function class_teachers(string $id){
    
    $classroom = Classroom::find($id)->first();
        $class_teachers=$classroom->teachers;
  
    return $class_teachers;
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     
        try {


            $parent = new Parents();
            $parent->first_name = $request->first_name;
            $parent->last_name = $request->last_name;
          
            $parent->phone = $request->phone;
            $parent->email = $request->email;
          
            $parent->student_id = $request->student_id;
            $parent->password = Hash::make($request->password);
            if ($img = $request->file('image')) {


                $parent->image = $this->UploadImage($img,'parents');
            }
            $parent->save();
            toastr('parent created successfully');
            return redirect()->route('dashboard.parents.index');
        }
         catch (Exception $e) {
            toastr($e->getMessage(), 'warning', 'there is an error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function departmentClassrooms(string $id)
    {

        $depClassrooms = Classroom::where('department_id', $id)->pluck('name', 'id');
        return $depClassrooms;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parents $parent)
    {
        $students = Student::all();
        $departments = Department::all();
        $classrooms = Classroom::all();
        return view('Parents.edit', compact('parent', 'departments', 'classrooms','students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parents $parent)
    {
        try {
            $input=$request->except('image');

            if ($request->phone) {
                $input['password'] = Hash::make($request->phone);
            }
            if ($img = $request->hasFile('image')) {
                $this->deleteImage($parent->image);
                $input['image']=$this->uploadImage($img,'parents');
            }

            $parent->update($input);
            toastr('parent updated successfully');
            return redirect()->route('dashboard.parents.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning', 'there is error');
            return redirect()->route('dashboard.parents.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parents $parent)
    {
        try {

            if ($parent->image) {
                $this->deleteImage($parent->image);
            }

            $parent->delete();
            toastr('parent deleted successfully','warning');
            return redirect()->route('dashboard.parents.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning');
            return redirect()->back();
        }
    }
}
