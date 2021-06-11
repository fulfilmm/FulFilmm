<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    use HasFactory;
    public function ticket_status(){
        return $this->belongsTo(status::class,'status','id');
    }
    public function ticket_priority(){
        return $this->belongsTo(priority::class,'priority','id');
    }
    public function sender_info(){
        return $this->belongsTo(ticket_sender::class,'customer_id','id');
    }
    public function created_by(){
        return $this->belongsTo(Employee::class,'created_emp_id','id');
    }
    public function assign_ticket(){
        return $this->hasMany(assign_ticket::class);
    }
}
