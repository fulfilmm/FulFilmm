<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;
    public function purchaseorder(){
        return $this->belongsTo(PurchaseOrder::class,'po_id','id');
    }

    public function delivery(){
        return $this->belongsTo(DeliveryOrder::class,'delivery_id','id');
    }

}
