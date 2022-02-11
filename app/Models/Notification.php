<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable=[
        'uuid',
        'type',
        'target_url',
        'notify_user_id',
        'message',
        'notifier_id',
    ];
    public function notify_user(){
        return $this->belongsTo(Employee::class,'notify_user_id','id');
    }
    public function notifier(){
        return $this->belongsTo(Employee::class,'notifier_id','id');
    }
}
