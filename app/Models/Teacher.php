<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['first_name','last_name','phone', 'email','password','subject_id','monitor_id','department_id','fingerPrint'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class,'teacher_classrooms','teacher_id','classroom_id');
    }
}
