<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReceiveItem extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
}
