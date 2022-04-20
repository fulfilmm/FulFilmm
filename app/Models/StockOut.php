<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;
    protected $fillable=['qty','customer_id','emp_id',
        'variantion_id','approver_id','courier_id',
        'warehouse_id','description','approve',
        'invoice_id','type','sell_unit','creator_id','branch_id'
    ];
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variantion_id','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function approver(){
        return $this->belongsTo(Employee::class,'approver_id','id');

    }
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function unit(){
        return $this->belongsTo(SellingUnit::class,'sell_unit','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
