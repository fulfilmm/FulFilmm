<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lead_follower extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(Employee::class,'follower_id','id');
    }
    public function leads(){
        return $this->belongsTo(Customer::class,'contact_id','id');
    }
}
