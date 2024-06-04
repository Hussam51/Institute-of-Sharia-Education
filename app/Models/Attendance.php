<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable=['department_id','classroom_id','student_id','attendance_status','attendance_date'];

    public function student(){
        
        return $this->belongsTo(Student::class);
    }
}
