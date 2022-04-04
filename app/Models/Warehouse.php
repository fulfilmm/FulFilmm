<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable=['name','description','is_virtual','address',
        'warehouse_id','mobile_warehouse','main_warehouse_id','branch_id'];
    public function branch(){
        return $this->belongsTo(OfficeBranch::class,'branch_id','id');
    }
    public function main_warehouse(){
        return $this->belongsTo(Warehouse::class,'main_warehouse_id','id');
    }

}
