<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_name','id');
    }
    public function sale_person(){
        return $this->belongsTo(Employee::class,'sale_person_id','id');
    }
    public function deal(){
        return $this->belongsTo(deal::class,'deal_id','id');
    }
    public function tax(){
        return $this->belongsTo(products_tax::class,'tax_id','id');
    }

}
