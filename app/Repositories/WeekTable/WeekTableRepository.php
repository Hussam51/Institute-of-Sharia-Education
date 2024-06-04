<?php

namespace App\Repositories\Classroom;

use App\Http\Requests\Classrooms\storeClassroomRequest;
use App\Models\WeekTable;
use App\Models\Department;
use App\Repositories\WeekTable\WeekTableRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class WeekTableRepository implements WeekTableRepositoryInterface
{
    public function getAll()
    {
        $departments = Department::all();
        $weekTables = WeekTable::all();

        return view('Classrooms.classroom', compact('departments', 'weekTables'));
    }

    public function add($request)
    {
        try {

            foreach ($request->list_classes as $list_class) {

             //   Classroom::create($list_class);
            }
            toastr()->success('created successfully');
            return redirect()->route('dashboard.classrooms.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors("Warning", $e->getMessage());
        }
    }

    public function update($request, WeekTable $weekTable)
    {

        try {
            $weekTable->update($request->validated());
            toastr()->success('updated successfully');
            return redirect()->route('dashboard.classrooms.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors("success", $e->getMessage());
        }
    }

    public function delete(WeekTable $classroom)
    {
        $classroom->delete();
        toastr()->success('deleted successfully');
        return redirect()->route('dashboard.classrooms.index');
    }
    public function deleteChecked($request)
    {
        $selectedclassrooms = $request->input('classrooms', []);

        if (!empty($selectedclassrooms)) {
            WeekTable::whereIn('id', $selectedclassrooms)->delete();
            Toastr('Selected classrooms have been deleted.', 'success');
            return redirect()->route('dashboard.classrooms.index');
        } else {
            Toastr('No classrooms were selected for deletion.', 'warning');
            return redirect()->route('dashboard.classrooms.index');
        }
    }
}
