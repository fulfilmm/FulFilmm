<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;
    protected $fillable=[
        'no','manager_id','tag_finance_id','amount','date','manager_approve',
        'finance_approve','emp_id','description','status','remaining'
    ];
    public function manager(){
        return $this->belongsTo(Employee::class,'manager_id','id');

    }
    public function finance(){
        return $this->belongsTo(Employee::class,'tag_finance_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
