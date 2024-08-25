<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Teacher extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable = ['first_name','last_name','phone', 'email','password','subject_id','monitor_id','department_id','fingerPrint','image'];

// get image url
    public function getImageUrl()
    {
        if ($this->image) {
            return asset('uploads/'.$this->image);
        }
      else
        return asset('assets/images/profile-avatar.jpg'); // توجد صورة افتراضية للطلاب في حالة عدم وجود صورة
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class,'teacher_classrooms','teacher_id','classroom_id');
    }


    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function duties()
    {
        return $this->hasMany(Homework::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class, 'questions' );
    }

    public function teacherWeekTable()
    {
        return $this->hasMany(TeacherWeekTimes::class);
    }

    public function attendances(){

        return $this->hasMany(TeacherAttendance::class,'teacher_id','id');
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
