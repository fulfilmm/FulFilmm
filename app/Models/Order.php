<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function quotation(){
        return $this->belongsTo(Quotation::class,'quotation_id','id');
    }
    public function tax(){
        return $this->belongsTo(products_tax::class,'tax_id','id');
    }
}
