<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable=['variant_id','product_name','product_id','stock_balance','available','warehouse_id','alert_qty','product_location'];
    use HasFactory;
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
}
