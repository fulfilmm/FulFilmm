<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvalrequest extends Model
{
    use HasFactory;
    public function approver(){
        return $this->belongsTo(Employee::class,'approved_id','id');
    }
    public function secondary_approver(){
        return $this->belongsTo(Employee::class,'secondary_approved','id');
    }
    public function request_emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function cc(){
        return $this->hasMany(Cc_of_approval::class);
    }

}
