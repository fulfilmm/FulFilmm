<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;
    public function vendor(){
        return $this->belongsTo(Customer::class,'vendor_id','id');

    }
    public function approver(){
        return $this->belongsTo(Employee::class,'approver_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'creator_id','id');
    }
}
