<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesWayAssign extends Model
{
    use HasFactory;
    protected $fillable=[
        'way_id','type','group_id','emp_id','assigned_emp','start_date','branch_id'
    ];
    public function way(){
        return $this->belongsTo(SaleWay::class,'way_id','id');
    }
    public function group(){
        return $this->belongsTo(SaleGroup::class,'group_id','id');
    }
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function assign_employee(){
        return $this->belongsTo(Employee::class,'assigned_emp','id');
    }
}
