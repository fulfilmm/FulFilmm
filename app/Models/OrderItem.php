<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public function invoice(){
        return $this->belongsTo(Invoice::class,'inv_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function unit(){
        return $this->belongsTo(SellingUnit::class,'sell_unit','id');
    }
    public function allunit(){
        return $this->hasMany(SellingUnit::class,'product_id','product_id');
    }
}
