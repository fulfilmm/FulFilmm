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
}
