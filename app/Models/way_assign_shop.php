<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class way_assign_shop extends Model
{
    use HasFactory;
    protected $fillable=['way_id','shop_id','reach_location','branch_id'];
    public function shop(){
        return $this->belongsTo(ShopLocation::class,'shop_id','id');
    }
}
