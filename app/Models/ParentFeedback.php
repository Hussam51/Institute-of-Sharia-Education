<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentFeedback extends Model
{
    use HasFactory;
    
    protected $fillable=['parent_id','admin_id','note','sent_at'];




    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
        
    }
}
