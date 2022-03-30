<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceProductPromotion extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'promotion_price', 'start_date', 'end_date','note','status'];

    public function promotionProduct()
    {
        return $this->belongsTo(EcommerceProduct::class, 'product_id', 'id');
    }
}
