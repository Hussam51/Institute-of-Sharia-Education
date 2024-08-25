<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable=["name","notes"];

    // relationship between Classroom and Department
    public function classrooms(){
        return $this->hasMany(Classroom::class,"department_id","id");
    }


    public function students(){
        return $this->hasMany(Student::class,"department_id","id");
    }


    public function admin(){
        return $this->hasOne(User::class,'department_id','id');
    }


    public function exam()
    {

        return $this->hasMany(Exam::class, 'department_id', 'id');
    }

    
}
