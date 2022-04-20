<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedProduct extends Model
{
    use HasFactory;
    protected $fillable=['variant_id','warehouse_id','emp_id','qty','branch_id'];
    public function  variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
