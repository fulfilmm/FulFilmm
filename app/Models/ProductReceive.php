<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReceive extends Model
{
    use HasFactory;
    public function purchaseorder(){
        return $this->belongsTo(PurchaseOrder::class,'po_id','id');
    }
    public function vendor(){
        return $this->belongsTo(Customer::class,'vendor_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
