<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    public function taxes(){
        return $this->belongsTo(products_tax::class,'tax','id');
    }
    public function category(){
        return $this->belongsTo(products_category::class,'cat_id','id');
    }
    public function sub_cat(){
        return $this->belongsTo(products_category::class,'sub_cat_id','id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

}
