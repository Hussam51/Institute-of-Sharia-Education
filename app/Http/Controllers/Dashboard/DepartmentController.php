<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Departments\storeDepartmentRequest;
use App\Http\Requests\Departments\updateDepartmentRequest;
use App\Models\Department;
use App\Repositories\Department\DepartmentRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{



    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->departmentRepository->getAll();
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
    public function store(storeDepartmentRequest $request)
    {
        return $this->departmentRepository->add($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateDepartmentRequest $request, Department $department)
    {
        return $this->departmentRepository->update($department, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        return $this->departmentRepository->delete($department);
    }
}
