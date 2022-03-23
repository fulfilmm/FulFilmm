<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueBudgetItem extends Model
{
    use HasFactory;
    protected $fillable=['total','revenue_budget_id','coa_id','cost_center','department','jan','feb','mar','apr',
    'may','jun','jul','aug','sep','oct','nov','dec'];
    public function coa(){
        return $this->belongsTo(ChartOfAccount::class,'coa_id','id');
    }
}
