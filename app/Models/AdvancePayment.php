<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
    use HasFactory;
    protected $fillable=['amount','emp_id','customer_id','payment_type','approver_id'];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }

    public function approver(){
        return $this->belongsTo(Employee::class,'approver_id','id');
    }
}
