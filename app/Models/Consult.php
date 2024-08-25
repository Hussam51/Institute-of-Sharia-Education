<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    use HasFactory;

    protected  $fillable=['adviser_id','student_id','consult','is_anonymous','answered'];





    public function replies()
    {
        return $this->hasMany(ConsultReply::class, 'consult_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function adviser()
    {
        return $this->belongsTo(Adviser::class);
    }

}
