<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeBranch extends Model
{
    use HasFactory;
    protected $fillable=['name','address','warehouse_id'];
    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
}
