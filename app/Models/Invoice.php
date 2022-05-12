<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function tax(){
        return $this->belongsTo(products_tax::class,'tax_id','id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function branch(){
        return $this->belongsTo(OfficeBranch::class,'branch_id','id');
    }
    public function zone(){
        return $this->belongsTo(SaleZone::class,'zone_id','id');
    }
    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }
    public function item(){
        return $this->hasMany(OrderItem::class,'inv_id','id');
    }
}
