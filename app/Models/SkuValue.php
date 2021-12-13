<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuValue extends Model
{
    use HasFactory;
    public function variant(){
        return $this->belongsTo(VariantKey::class,'variant_id','id');
    }
    public function variant_value(){
        return $this->belongsTo(VariantValue::class,'vaiiant_value_id','id');
    }
}
