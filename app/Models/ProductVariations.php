<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    protected $fillable=['product_id','product_name','description','item_code','enable','image','variant','additional_price'];
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
    public function stock(){
        return $this->hasMany(Stock::class);
    }
    public function supplier(){
        return $this->belongsTo(Customer::class,'supplier_id','id');
    }
    public function unit(){
        return $this->hasMany(SellingUnit::class);
    }

}
