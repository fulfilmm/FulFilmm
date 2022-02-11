<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;
    public function stockin(){
        return $this->belongsTo(StockIn::class,'stock_in','id');
    }
    public function stockout(){
        return $this->belongsTo(StockOut::class,'stock_out','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
}
