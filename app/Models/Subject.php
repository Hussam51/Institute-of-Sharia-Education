<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
 public $timestamps=false;
    protected $fillable=['name','classroom_id'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'subject_id', 'student_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class,'subject_id','id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);

    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }




    public function duties()
    {
        return $this->hasMany(Homework::class);
    }

    public function exam()
    {
        return $this->hasMany(Exam::class);
    }

    public function teacherWeekTable()
    {
        return $this->hasMany(TeacherWeekTimes::class);
    }


}
