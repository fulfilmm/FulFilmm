<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    public function emp(){
        return $this->belongsTo(Employee::class,'meeting_creater','id');
    }
    public function meeting_room(){
        return $this->belongsTo(Room::class,'room_no','id');
    }
}
