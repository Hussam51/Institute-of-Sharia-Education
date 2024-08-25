<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHomework extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'homework_id', 'homework', 'completed'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function duty()
    {
        return $this->belongsTo(Homework::class);
    }
}
