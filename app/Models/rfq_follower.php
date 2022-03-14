<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rfq_follower extends Model
{
    use HasFactory;
    protected $fillable=['emp_id','rfq_id'];
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
