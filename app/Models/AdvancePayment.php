<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
    use HasFactory;
    protected $fillable=['order_id','amount','emp_id','account_id','customer_id','type','payment_type','transaction_done'];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function account(){
        return $this->belongsTo(Account::class,'account_id','id');
    }
}
