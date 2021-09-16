<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticketrequest extends Model
{
    use HasFactory;
    public function compalin_product(){
        return $this->belongsTo(product::class,'product_id','id');

    }
    public function complain_company (){
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
