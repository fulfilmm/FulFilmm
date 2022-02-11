<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockUpdatedHistory extends Model
{
    use HasFactory;
    protected $fillable=['warehouse_id','stock_id','variant_id'];
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');

    }
    public function stock(){
        return $this->belongsTo(Stock::class,'stock_id','id');
    }
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
