<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['student_id','score','comment'];
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
