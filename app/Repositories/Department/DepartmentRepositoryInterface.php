<?php
namespace App\Repositories\Department;

use App\Models\Department;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    public function getAll();

    public function add($request);

    public function update(Department $department,$request);

    public function delete(Department $classroom);
    public function deleteChecked();
}
