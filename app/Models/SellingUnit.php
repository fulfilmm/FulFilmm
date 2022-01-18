<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingUnit extends Model
{
    use HasFactory;
    protected $fillable=['variant_id','unit','price','sale_type','barcode','active'];
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
}
