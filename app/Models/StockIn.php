<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variantion_id','id');
    }
    public function supplier(){
        return $this->belongsTo(Customer::class,'supplier_id','id');
    }
}
