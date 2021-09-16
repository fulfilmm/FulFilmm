<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_assign extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'dept_id','id');
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id','id');
    }
}
