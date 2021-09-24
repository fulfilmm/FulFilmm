<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public function expense(){
        return $this->belongsTo(Expense::class,'expense_id','id');
    }
    public function revenue(){
        return $this->belongsTo(Revenue::class,'revenue_id','id');
    }
    public function account(){
        return $this->belongsTo(Account::class,'account_id','id');
    }
}
