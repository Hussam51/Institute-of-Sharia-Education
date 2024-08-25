<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;
    protected $table='transports';
    protected $fillable = [
        'route_name',
        'start_location',
        'end_location',
        'departure_time',
        'arrival_time',
        'vehicle_type',
        'department_id'
    ];


    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_transports');
    }
}
