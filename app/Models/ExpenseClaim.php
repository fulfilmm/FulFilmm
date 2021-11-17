<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseClaim extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function approver(){
        return $this->belongsTo(Employee::class,'approver_id','id');
    }
    public function finance_approver(){
        return $this->belongsTo(Employee::class,'financial_approver','id');
    }
}
