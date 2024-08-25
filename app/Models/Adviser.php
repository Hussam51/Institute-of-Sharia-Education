<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Adviser extends Authenticatable implements JWTSubject

{

    use HasFactory;
    protected $fillable=['first_name','last_name','password','phone','photo','department_id'];


    public function consult(){

        return $this->hasMany(Consult::class,'adviser_id','id');
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




    // get image url
    public function getPhotoUrl()
    {
        if ($this->photo) {
            return asset('uploads/'.$this->photo);
        }
      else
        return asset('assets/images/profile-avatar.jpg'); // توجد صورة افتراضية للطلاب في حالة عدم وجود صورة
    }




}
