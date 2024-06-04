<?php
namespace App\Repositories\Teacher;

use App\Models\Teacher;
use Illuminate\Support\Collection;

interface TeacherRepositoryInterface
{
    public function getAll();

    public function add(array $data);

    public function update(Teacher $subject);

    public function delete(Teacher $classroom);
    public function deleteChecked();
}
