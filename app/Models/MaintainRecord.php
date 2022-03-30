<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintainRecord extends Model
{
    use HasFactory;

    protected $fillable = ['status','car_id','case', 'description', 'kilometer', 'workshop','service_date','driver', 'attaches','total','check'];
    
    
    public function car()
    {
        return $this->belongsTo(CarData::class);
    }

}
