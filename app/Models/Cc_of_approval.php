<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cc_of_approval extends Model
{
    use HasFactory;
    public function tag_emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function approval(){
        return $this->belongsTo(Approvalrequest::class,'approval_id','id');
    }
}