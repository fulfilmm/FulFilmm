<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;
    public function approval(){
        return $this->belongsTo(Approvalrequest::class,'approval_id','id');
    }
}
