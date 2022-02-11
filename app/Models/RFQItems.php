<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFQItems extends Model
{
    use HasFactory;
    protected $fillable=['rfq_id','product_id','description','qty','total','price','description','creation_id'];
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
}
