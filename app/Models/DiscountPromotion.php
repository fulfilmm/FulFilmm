<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPromotion extends Model
{
    use HasFactory;
    protected $fillable=['variant_id','type','rate','start_date','end_date','description','sale_type','region_id'];
    public function variant(){
        return $this->belongsTo(ProductVariations::class,'variant_id','id');
    }
    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }
}
