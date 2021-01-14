<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }


    public function user()
    {
        return $this->belongsTo(Employee::class, 'commenter_id');
    }
}
