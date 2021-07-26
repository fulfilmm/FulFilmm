<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assign_ticket extends Model
{
    use HasFactory;
    public function agent(){
        return $this->belongsTo(Employee::class,'agent_id','id');
    }
    public function dept(){
        return $this->belongsTo(Department::class,'dept_id','id');
    }
    public function ticket(){
        return $this->belongsTo(ticket::class,'ticket_id','id');
    }
}
