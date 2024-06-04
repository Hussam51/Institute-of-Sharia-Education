<?php
namespace App\Repositories\Classroom;

use App\Http\Requests\Classrooms\storeClassroomRequest;
use App\Models\Classroom;
use Illuminate\Support\Collection;

interface ClassroomRepositoryInterface
{
    public function getAll();

    public function add($request );

    public function update($request,Classroom $classroom);

    public function delete(Classroom $classroom);
    public function deleteChecked($request);
}
