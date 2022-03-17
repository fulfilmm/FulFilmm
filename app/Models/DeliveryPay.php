<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPay extends Model
{
    use HasFactory;
    protected $fillable=['delivery_id','delivery_code','delivery_fee',
        'invoice_amount','paid_delivery_fee',
'receiver_invoice_amount','due_amount','courier_id'];
    public function delivery(){
        return $this->belongsTo(DeliveryOrder::class,'delivery_id','id');
    }
    public function courier(){
        return $this->belongsTo(Customer::class,'courier_id','id');
    }
}
