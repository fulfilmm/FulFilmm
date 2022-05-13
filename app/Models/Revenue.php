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
    public function branch_cashier(){
        return $this->belongsTo(Employee::class,'cashier','id');
    }
    public function manager(){
        return $this->belongsTo(Employee::class,'finance_manager','id');
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