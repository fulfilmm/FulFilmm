<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    protected $fillable=['po_id','variant_id','description','qty','total','price','description','creation_id'];
    public function product(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
}
