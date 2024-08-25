<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherWeekTimes extends Model
{
    use HasFactory;
    protected $table = 'teacher_week_times';
    
    protected $fillable = ['day', 'teacher_id', 
                           'start_time', 'end_time',
                           'classroom_id'
                          ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
