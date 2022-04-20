<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountDiscount extends Model
{
    use HasFactory;
    protected $fillable=['min_amount','max_amount','start_date','end_date','has_date_limit',
        'rate','description','sale_type','branch_id'];
    public function branch(){
        return $this->belongsTo(OfficeBranch::class,'branch_id','id');
    }
}
