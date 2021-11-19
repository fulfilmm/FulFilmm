<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
    public function stock(){
        return $this->hasMany(Stock::class);
    }
}