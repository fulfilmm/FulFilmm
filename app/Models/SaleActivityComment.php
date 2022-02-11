<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleActivityComment extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
