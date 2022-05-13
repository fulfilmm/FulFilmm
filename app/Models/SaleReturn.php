<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    protected $fillable=['invoice_id','customer_id','sale_man_id','amount','reason','attach','branch_id','account_id','cashier_id','category'];
    public function saleman(){
        return $this->belongsTo(Employee::class,'sale_man_id','id');
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id','id');

    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function branch(){
        return $this->belongsTo(OfficeBranch::class,'branch_id','id');
    }
    public function cashier(){
        return $this->belongsTo(Employee::class,'cashier_id','id');
    }
}
