<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;
    protected $table = 'libraries';
    protected $fillable = [
        'file_url', 'title',
        'subject_id', 'teacher_id',
        'classroom_id', 'type',  'status'
    ];

    public function getImageUrl()
    {
        if ($this->file_url) {
            return asset('uploads/'.$this->file_url);
        }
    }
    public function classroom()
    {
        return $this->belongsTo(classroom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
