<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceive extends Model
{
    use HasFactory;
    protected $fillable=['receive_date','amount','customer_id','emp_id','description','type'];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
