<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReceive extends Model
{
    use HasFactory;
    public function rfq(){
        return $this->belongsTo(RequestForQuotation::class,'rfq_id','id');
    }
    public function vendor(){
        return $this->belongsTo(Customer::class,'vendor_id','id');
    }
}
