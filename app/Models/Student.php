<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['data_birth', 'password', 'classroom_id', 'department_id', 'first_name', 'last_name', 'image'];


    public function getImageUrl()
    {
        if ($this->image) {
            return asset($this->image);
        }
      else
        return asset('assets/images/profile-avatar.jpg'); // توجد صورة افتراضية للطلاب في حالة عدم وجود صورة
    }








 // many to many  relationship between student and your subjects
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }

 // one to many  relationship between student and your classroom
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

  // one to many  relationship between student and department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

   // one to many relationship between student and your attendances
    public function attendances(){

        return $this->hasMany(Attendance::class,'student_id','id');
    }

    // one to one  relationship between student and parent
    public function parent()
    {
        return $this->belongsTo(Parent::class);
    }
}
