<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingUnit extends Model
{
    use HasFactory;
    protected $fillable=['product_id','unit','unit_convert_rate','active'];
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
}
