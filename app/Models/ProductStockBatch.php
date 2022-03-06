<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockBatch extends Model
{
    use HasFactory;
    protected $fillable=[
       'product_id',
        'batch_no',
        'supplier_id',
        'qty',
        'purchase_price',
        'exp_date'
    ];
    public function supplier(){
        return $this->belongsTo(Customer::class,'supplier_id','id');

    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'product_id','id');
    }
}
