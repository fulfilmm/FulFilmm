<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceProductAdd extends Model
{
    use HasFactory;

    protected $fillable = ['product_id' ,'cover', 'photos', 'price', 'description'];

  
   public function product()
   {
       return $this->belongsTo(EcommerceProduct::class, 'product_id', 'id');
   }
}
