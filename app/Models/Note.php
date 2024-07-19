<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    
    public $timestamps = false;


    protected $fillable = [
        'student_id',
        'admin_id',
        'parent_id',
        'note',
        'type',
        'sent_by',
        'sent_at',
    ];



    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }



    public function student()
    {
        return $this->belongsTo(Student::class);
    }



    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
