<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForQuotation extends Model
{
    use HasFactory;
    public function vendor(){
        return $this->belongsTo(Customer::class,'vendor_id','id');

    }
    public function source(){
        return $this->belongsTo(PurchaseRequest::class,'pr_id','id');
    }
}
