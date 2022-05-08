<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function approver(){
        return $this->belongsTo(Employee::class,'regional_cashier','id');
    }
    public function branch_approver(){
        return $this->belongsTo(Employee::class,'branch_cashier','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }
//    public function account(){
//        return $this->belongsTo(ChartOfAccount::class,'coa_id','id');
//    }
    public function cat(){
        return $this->belongsTo(TransactionCategory::class,'category','id');
    }
}
