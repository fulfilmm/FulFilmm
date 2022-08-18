<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class next_plan extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'contact_id','id');
    }
}
