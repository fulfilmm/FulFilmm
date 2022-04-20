<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReturn extends Model
{
    use HasFactory;
    protected $fillable=[
        'inv_id','description','variant_id','customer_id','emp_id',
        'attachment','warehouse_id','sell_unit','creator_id','qty','transfer_warehouse','category'
    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class,'inv_id','id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function unit(){
        return $this->belongsTo(SellingUnit::class,'sell_unit','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function creator(){
        return $this->belongsTo(Employee::class,'creator_id','id');
    }
}
