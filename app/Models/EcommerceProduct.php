<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceProduct extends Model
{
    use HasFactory;
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'product_id','id');
    }
}
