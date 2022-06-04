<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaletargetItem extends Model
{
    use HasFactory;
    protected $fillable=['sale_target_id','item_id','target_qty'];
    public function product(){
        return $this->belongsTo(ProductVariations::class,'item_id','id');
    }
}
