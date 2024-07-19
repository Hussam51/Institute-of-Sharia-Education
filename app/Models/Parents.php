<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Parents extends Model implements JWTSubject
{
    use HasFactory;



    protected $fillable = [ 'password', 'student_id', 'first_name', 'last_name', 'image','email','phone'];

    public function getImageUrl()
    {
        if ($this->image) {
            return asset('uploads/'.$this->image);
        }
      else
        return asset('assets/images/profile-avatar.jpg'); // توجد صورة افتراضية للطلاب في حالة عدم وجود صورة
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


    //************* /     relationships       / *******/////////

    public function student(){
        return $this->belongsTo(Student::class);
    }

    
}
