<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
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
}
