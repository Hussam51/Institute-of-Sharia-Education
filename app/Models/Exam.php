<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
         'term', 'subject_id', 'exam_date',
        'exam_duration', 'department_id', 'classroom_id'
    ];

    //  relationship with classroom

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    //  relationship with department

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    //  relationship with subject

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
