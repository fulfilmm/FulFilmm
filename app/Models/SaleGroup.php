<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleGroup extends Model
{
    use HasFactory;
    protected $fillable=['name','emp_id','branch_id'];
    public function employee(){
        $this->belongsTo(Employee::class,'emp_id','id');
    }
}
