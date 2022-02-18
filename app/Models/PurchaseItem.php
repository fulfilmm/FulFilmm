<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    protected $fillable=['product_id','creation_id','qty','price','total','pr_id','description','unit'];
    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }
}
