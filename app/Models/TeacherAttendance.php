<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance  extends Model
{
    use HasFactory;
    protected $fillable=['teacher_id','attendance_status','attendance_date'];
}