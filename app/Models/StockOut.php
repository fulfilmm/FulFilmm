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
        'invoice_id','type'
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
}
