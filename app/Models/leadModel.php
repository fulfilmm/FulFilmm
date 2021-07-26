<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leadModel extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function saleMan(){
        return $this->belongsTo(Employee::class,'sale_man_id','id');
    }
    public function tags(){
        return $this->belongsTo(tags_industry::class,'tags_id','id');
    }
}
