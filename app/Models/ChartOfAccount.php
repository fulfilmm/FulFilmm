<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;
    protected $fillable=['name','code','type','group','sub_group','financial_statement','normally'];
    public function account_type(){
        return $this->belongsTo(COAType::class,'type','id');
    }
}
