<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_follower extends Model
{
    use HasFactory;
    public function ticket_followed(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
    public function ticket(){
        return $this->belongsTo(ticket::class,'ticket_id','id');
    }
}
