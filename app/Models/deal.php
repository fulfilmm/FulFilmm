<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deal extends Model
{
    use HasFactory;
    protected $fillable=['name','amount','unit','org_name','contact','assign_to', 'close_date',
            'pipeline','sale_stage','lead_source','next_step','type','probability','weighted_revenue',
            'weighed_revenue_unit','lost_reason','description','created_id',
 ];
public function customer_company(){
    return $this->belongsTo(Company::class,'org_name','id');
}
public function customer(){
    return $this->belongsTo(Customer::class,'contact','id');
}
public function employee(){
    return $this->belongsTo(Employee::class,'assign_to','id');
}
public function created_person(){
    return $this->belongsTo(Employee::class,'created_id','id');
}
}
