<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopLocation extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'location',
        'customer_id',
        'picture',
        'contact',
        'phone',
        'description',
        'emp_id',
        'branch_id',
        'region_id',
        'zone_id',
        'township',
        'address',
        'shop_type'
    ];
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function branch(){
        return $this->belongsTo(OfficeBranch::class,'branch_id','id');
    }
    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }
    public function zone(){
        return $this->belongsTo(SaleZone::class,'zone_id','id');
    }
}
