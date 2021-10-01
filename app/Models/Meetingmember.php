<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meetingmember extends Model
{
    use HasFactory;
    public function meeting(){
        return $this->belongsTo(Meeting::class,'meeting_id','id');
    }
    public function emp_member(){
        return $this->belongsTo(Employee::class,'member_id','id');
    }
    public function external(){
        return $this->belongsTo(ExternalMeetingMember::class,'external_member_id','id');
    }
}
