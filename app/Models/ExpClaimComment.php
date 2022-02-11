<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpClaimComment extends Model
{
    use HasFactory;
    public function comment_user(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
