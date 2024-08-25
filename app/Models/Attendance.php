<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable=['department_id','classroom_id','student_id','attendance_status','attendance_date','absent_reason'];

    public function student(){

        return $this->belongsTo(Student::class);
    }



    public function ispresent($classroomId, $attendanceDate)
    {
        $attendance = Attendance::where('student_id', $this->id)
            ->where('classroom_id', $classroomId)
            ->where('attendance_date', $attendanceDate)
            ->first();

        return $attendance && $attendance->attendance_status == 'حاضر';
    }
}
