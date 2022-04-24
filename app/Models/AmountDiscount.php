<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountDiscount extends Model
{
    use HasFactory;
    protected $fillable=['min_amount','max_amount','start_date','end_date','has_date_limit',
        'rate','description','sale_type','region_id'];
    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }
}
