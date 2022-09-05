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
    public function bill(){
        return $this->belongsTo(Bill::class,'bill_id','id');
    }
//    public function account(){
//        return $this->belongsTo(ChartOfAccount::class,'coa_id','id');
//    }
    public function cat(){
        return $this->belongsTo(TransactionCategory::class,'category','id');
    }
    public function petty_cash(){
        return $this->belongsTo(PettyCash::class,'petty_cash_id','id');
    }
}
