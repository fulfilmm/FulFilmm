<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopLocation extends Model
{
    use HasFactory;
    protected $fillable=['name',
        'location','customer_id','picture',
        'contact',
        'phone',
        'description',
        'emp_id'];
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
