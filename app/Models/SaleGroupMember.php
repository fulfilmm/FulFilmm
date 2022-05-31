<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleGroupMember extends Model
{
    use HasFactory;
    protected $fillable=['group_id','emp_id'];
    public function emp(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
