<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freeofchare extends Model
{
    use HasFactory;
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function emp(){
        return $this->belongsTo(Employee::class,'issuer_id','id');
    }
}
