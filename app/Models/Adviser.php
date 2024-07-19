<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{

    use HasFactory;
    protected $fillable=['name','password','phone','photo','department_id'];

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
