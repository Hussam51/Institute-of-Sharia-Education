<?php

namespace App\Repositories\Department;

use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Models\Department;
use Illuminate\Support\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getAll()
    {
        $departments = Department::all();
        return view('Departments.department', compact('departments'));
    }

    public function add($request)
    {

        try {

            Department::create($request);
            toastr()->success('created successfully');
            return redirect()->route('dashboard.departments.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function update(Department $department,$request)
    {

        try {

            $department->update($request);
            return redirect()->route('dashboard.departments.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function delete(Department $department)
    {

        $department->delete();
        toastr()->error("deleted successfully");
        return redirect()->route('dashboard.departments.index');
    }



    public function deleteChecked()
    {
    }
}
