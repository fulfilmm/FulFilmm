<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransferRecord extends Model
{
    use HasFactory;
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function from(){
        return $this->belongsTo(Warehouse::class,'from_warehouse','id');
    }
    public function to(){
        return $this->belongsTo(Warehouse::class,'to_warehouse','id');
    }
}
