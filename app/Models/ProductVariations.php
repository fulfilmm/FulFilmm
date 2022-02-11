<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    protected $fillable=['product_id','product_name','description','serial_no','purchase_price','product_code','exp_date','enable','image','variant'];
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
    public function stock(){
        return $this->hasMany(Stock::class);
    }

}
