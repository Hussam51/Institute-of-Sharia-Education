<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultReply extends Model
{
    use HasFactory;

    protected $fillable = ['adviser_id','consult_id', 'reply'];

    public function consult()
    {
        return $this->belongsTo(Consult::class, 'consult_id');
    }

    public function adviser()
    {
        return $this->belongsTo(Adviser::class, 'adviser_id');
    }

}
