<?php
namespace App\Repositories\WeekTable;


use App\Models\WeekTable;
use Illuminate\Support\Collection;

interface WeekTableRepositoryInterface
{
    public function getAll();

    public function add($request );

    public function update($request,WeekTable $weekTable);

    public function delete(WeekTable $weekTable);
    public function deleteChecked($request);
}
