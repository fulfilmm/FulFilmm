<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;
    protected $fillable=['room_id','start_time','endtime','created_emp','subject'];
    public function bookroom(){
        return $this->belongsTo(Room::class,'room_id','id');
    }
    public function booking_emp(){
        return $this->belongsTo(Employee::class,'created_emp','id');
    }
}
