<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_price extends Model
{
    use HasFactory;
    protected $fillable=['product_id','unit_id','sale_type','price','rule','max','min','start_date','end_date','multi_price'];
    public function unit(){
        return $this->belongsTo(SellingUnit::class,'unit_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'product_id','id');
    }
}
