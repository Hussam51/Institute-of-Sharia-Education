<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classrooms\storeClassroomRequest;
use App\Http\Requests\Classrooms\updateClassroomRequest;
use App\Http\Requests\Departments\updateDepartmentRequest;
use App\Models\Classroom;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use App\Repositories\Classroom\ClassroomRepositoryInterface;
use Illuminate\Support\Facades\App;

class ClassroomController extends Controller
{


    /// use repository design pattern ///////
       // classroom repository     //
    protected $classroomRepository;

    public function __construct(ClassroomRepositoryInterface $classroomRepository)
    {
        $this->classroomRepository = $classroomRepository;
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return $this->classroomRepository->getAll();
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
    public function store(storeClassroomRequest $request)
    {

        return $this->classroomRepository->add($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateClassroomRequest $request, Classroom $classroom)
    {

        return $this->classroomRepository->update($request->all(), $classroom);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        return $this->classroomRepository->delete($classroom);
    }



    public function deleteChecked( Request $request)
    {

        return $this->classroomRepository->deleteChecked($request);
    }
}
