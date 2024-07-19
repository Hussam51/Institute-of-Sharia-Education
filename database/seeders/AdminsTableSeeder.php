<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => 'Mohammed Doe',
                'email' => 'mohammed@gmail.com',
                'password' => Hash::make('password'),
                'department_id'=>1
              
            ]
        );
        User::create(
            [
                'name' => 'Ahmed Doe',
                'email' => 'ahmed@gmail.com',
                'password' => Hash::make('password'),
                'department_id'=>2
            ]
        );
    }
}
