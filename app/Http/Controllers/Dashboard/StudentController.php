<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Student;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();

        $students = Student::all();
        $classrooms = Classroom::all();
        return view('Students.index', compact('departments', 'classrooms', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('Students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {


            $student = new Student();
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->data_birth = $request->data_birth;
            $student->phone = $request->phone;
            $student->email = $request->email;
            $student->classroom_id = $request->classroom_id;
            $student->department_id = $request->department_id;
            $student->password = Hash::make($request->phone);
            if ($img = $request->file('image')) {


                $student->image = $this->UploadImage($img,'students');
            }
            $student->save();
            toastr('student created successfully');
            return redirect()->route('dashboard.students.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning', 'there is an error');
            return redirect()->route('dashboard.students.index');
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
    public function edit(Student $student)
    {
        $departments = Department::all();
        $classrooms = Classroom::all();
        return view('Students.edit', compact('student', 'departments', 'classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        try {
            $input=$request->except('image');

            if ($request->phone) {
                $input['password'] = Hash::make($request->phone);
            }
            if ($img = $request->hasFile('image')) {
                $this->deleteImage($student->image);
                $input['image']=$this->uploadImage($img,'students');
            }

            $student->update($input);
            toastr('student updated successfully');
            return redirect()->route('dashboard.students.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning', 'there is error');
            return redirect()->route('dashboard.students.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {

            if ($student->image) {
                $this->deleteImage($student->image);
            }

            $student->delete();
            toastr('student deleted successfully');
            return redirect()->route('dashboard.students.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning');
            return redirect()->back();
        }
    }
}
