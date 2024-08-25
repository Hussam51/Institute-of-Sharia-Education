<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['data_birth', 'password', 'classroom_id', 'department_id', 'first_name', 'last_name', 'image'];
  

    public function parent(){
        return $this->hasOne(Parents::class,'student_id','id');
    }


    public function scopeFilter(Builder $builder, $filters)
    {
           $builder->when($filters['first_name'] ?? false,function($builder,$value){
            $builder->where('students.first_name','LIKE',"%{$value}%");

           });
           $builder->when($filters['last_name']?? false,function($builder,$value){
              $builder->where('students.last_name','LIKE',"%{$value}%");
           });

           $builder->when($filters['father_name'] ?? false, function ($builder, $value) {
            $builder->whereHas('parent', function ($query) use ($value) {
                $query->where('first_name', 'LIKE', "%{$value}%");
            });
        });
          // $builder->when($filters['parent_name']?? false,function($builder,$value){
          //  $builder->where('parents.first_name','LIKE',"%{$value}%");
          //   });

    }

  
    public function getImageUrl()
    {
        if ($this->image) {
            return asset('uploads/'.$this->image);
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

    // one to one  relationship between student and rating


    public function consult(){

        return $this->hasMany(Consult::class,'student_id','id');
    }

    // one to one  relationship between student and parent
   

    public function transport()
    {
        return $this->belongsToMany(Transport::class, 'student_transports');
    }


    public function busNote(){

        return $this->hasMany(StudentTransport::class,'student_id','id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class,'student_id');
    }

    public function ispresent($classroomId, $attendanceDate)
    {
        $attendance = Attendance::where('student_id', $this->id)
            ->where('classroom_id', $classroomId)
            ->where('attendance_date', $attendanceDate)
            ->first();

        return $attendance && $attendance->attendance_status == 'حاضر';
    }



    public function dutie()
    {
        return $this->hasMany(Homework::class);
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class, 'student_homeworks');
    }

    public function rates()
    {
        return $this->hasMany(Rating::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
//    }
//    public function libraries()
//    {
//        return $this->hasMany(Library::class);
//
//    }


    public function questions()
    {
        return $this->hasMany(Question::class,'student_id','id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'questions');
    }
    
// jwt 


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
