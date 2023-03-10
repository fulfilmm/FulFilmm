<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpExpense extends Model
{
    use HasFactory;
    protected $fillable=['title','amount','description','attach','emp_id'];
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
