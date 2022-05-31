<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_category extends Model
{
    use HasFactory;
    protected $fillable=['name','parent_id','parent'];
    public function product(){
        return $this->hasMany(product::class);
    }
    public function main(){
        return $this->belongsTo(products_category::class,'parent_id','id');
    }
}
