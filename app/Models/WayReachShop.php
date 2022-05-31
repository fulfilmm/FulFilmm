<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WayReachShop extends Model
{
    use HasFactory;
    protected $fillable=[
        'assign_id','shop_id','emp_id','emp_location','reach'
    ];
    public function shop(){
        return $this->belongsTo(ShopLocation::class,'shop_id','id');
    }
}
