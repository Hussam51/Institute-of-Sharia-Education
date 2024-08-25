<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;


    protected $fillable=['student_id','teacher_id','question','answered'];



    public function replies()
    {
        return $this->hasMany(QuestionReply::class, 'question_id');
    }


    public function student()
    {

        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    
}
