<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacherName',
        'title',
        'reader_status',
    ];

    public function scopeCountNotification($query)
    {
        $query->where('reader_status',0);
    }
}
