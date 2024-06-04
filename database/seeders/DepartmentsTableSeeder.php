<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Department::create([
        'admin_id'=>1,
        'name'=>'male',

      ]);
      Department::create([
        'admin_id'=>2,
        'name'=>'female',

      ]);
    }
}
