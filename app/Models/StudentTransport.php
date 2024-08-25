<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransport extends Model
{
    use HasFactory;

    protected $fillable=['student_id','transport_id','note','status','parent_id','date'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }
}
