<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Monitor extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected  $fillable = ['first_name', 'last_name', 'password', 'department_id','phone'];


    public function department()
    {
        return $this->belongsTo(Department::class);
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
