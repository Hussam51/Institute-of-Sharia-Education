<?php

namespace App\Repositories\Classroom;

use App\Http\Requests\Classrooms\storeClassroomRequest;
use App\Repositories\Classroom\ClassroomRepositoryInterface;
use App\Models\Classroom;
use App\Models\Department;
use Exception;
use Illuminate\Support\Collection;

class ClassroomRepository implements ClassroomRepositoryInterface
{
    public function getAll()
    {
        $departments = Department::all();
        $classrooms = Classroom::all();

        return view('Classrooms.classroom', compact('departments', 'classrooms'));
    }

    public function add($request)
    {
        try {

            foreach ($request->list_classes as $list_class) {

                Classroom::create($list_class);
            }
            toastr()->success('created successfully');
            return redirect()->route('dashboard.classrooms.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors("Warning", $e->getMessage());
        }
    }

    public function update($request, Classroom $classroom)
    {

        try {
            $classroom->update($request->validated());
            toastr()->info('updated successfully');
            return redirect()->route('dashboard.classrooms.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors("error", $e->getMessage());
        }
    }

    public function delete(Classroom $classroom)
    {
        $classroom->delete();
        toastr()->warning('deleted successfully');
        return redirect()->route('dashboard.classrooms.index');
    }
    public function deleteChecked($request)
    {
        $selectedclassrooms = $request->input('classrooms', []);

        if (!empty($selectedclassrooms)) {
            Classroom::whereIn('id', $selectedclassrooms)->delete();
            Toastr('Selected classrooms have been deleted.', 'success');
            return redirect()->route('dashboard.classrooms.index');
        } else {
            Toastr('No classrooms were selected for deletion.', 'warning');
            return redirect()->route('dashboard.classrooms.index');
        }
    }
}
