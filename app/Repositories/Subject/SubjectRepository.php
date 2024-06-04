<?php
namespace App\Repositories\Subject;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Models\Subject;
use Exception;
use Illuminate\Support\Collection;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function getAll() {

    }

    public function add( $request){
        // dd($request->all());
            Subject::create($request->validated());

    }

    public function update($request,Subject $subject){
        


            $subject->update($request->all());
            toastr()->success('updated successfully');
           // return redirect()->route('dashboard.subjects.index');


    }

    public function delete(Subject $subject){

    }
    public function deleteChecked(){

    }
}
