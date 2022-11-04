<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesActivityAndShop extends Model
{
    use HasFactory;
    public function shop(){
        return $this->belongsTo(ShopLocation::class,'shop_id','id');
    }
}
