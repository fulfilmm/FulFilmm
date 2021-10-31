<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class,'inv_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
}
