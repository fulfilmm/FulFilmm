<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryComment extends Model
{
    use HasFactory;
    protected $fillable=['delivery_id','comment','emp_id','courier_id'];
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function courier(){
        return $this->belongsTo(Customer::class,'courier_id','id');
    }
}
