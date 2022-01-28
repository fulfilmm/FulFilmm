<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    public function supplier(){
        return $this->belongsTo(Customer::class,'vendor_id','id');
    }
    public function approver(){
        return $this->belongsTo(Employee::class,'approver_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
