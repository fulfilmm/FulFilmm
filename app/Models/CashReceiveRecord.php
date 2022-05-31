<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashReceiveRecord extends Model
{
    use HasFactory;
    protected $fillable=[
        'emp_id','receiver_id','sale_manager',
        'finance_manager','amount','description','attachment','receipt'
    ];
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function receiver(){
        return $this->belongsTo(Employee::class,'receiver_id','id');
    }
    public function salemanager(){
        return $this->belongsTo(Employee::class,'sale_manager','id');
    }
    public function financemanager(){
        return $this->belongsTo(Employee::class,'finance_manager','id');
    }
}
