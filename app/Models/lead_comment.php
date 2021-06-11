<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lead_comment extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(Employee::class,'user_id','id');
    }
}
