<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;
    protected $fillable=['state','courier_id','invoice_id','customer_id','delivery_id','delivery_date','delivery_fee',
        'warehouse_id','shipping_address','uuid','reach_date','estimate_date','draft_time','emp_id','receiver_phone',
        'delivery_type',
        'current_state',
        'pick_date',
        'remark',
        'amount_to_request','status'];
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }
    public function  courier(){
        return $this->belongsTo(Customer::class,'courier_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
