<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinutesAssign extends Model
{
    use HasFactory;
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function dept(){
        return $this->belongsTo(Department::class,'dept_id','id');
    }
}
