<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_comments extends Model
{
    use HasFactory;
    public function comment_user(){
        return $this->belongsTo(Employee::class,'user_id','id');
    }
}
