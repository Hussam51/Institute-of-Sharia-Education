<?php
namespace App\Repositories\Subject;

use App\Models\Subject;
use Illuminate\Support\Collection;

interface SubjectRepositoryInterface
{
    public function getAll();

    public function add( $request);

    public function update($request,Subject $subject);

    public function delete(Subject $classroom);
    public function deleteChecked();
}
