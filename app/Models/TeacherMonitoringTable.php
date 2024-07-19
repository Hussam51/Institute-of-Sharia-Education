<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherMonitoringTable extends Model
{
    use HasFactory;
    protected $table = 'teacher_monitoring';
    
    protected $fillable = ['date', 'teacher_id', 
                           'start_time', 'end_time',
                           'hall'
                          ];

    public function teacher()
     {
            return $this->belongsTo(Teacher::class);
     }
                      
}
