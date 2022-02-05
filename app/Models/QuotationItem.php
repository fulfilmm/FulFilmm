<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function unit(){
        return $this->belongsTo(SellingUnit::class,'unit_id','id');
    }
    public function discount(){
        return $this->belongsTo(DiscountPromotion::class,'discount_id','id');
    }

}
