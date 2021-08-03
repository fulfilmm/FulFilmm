<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityComment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'commenter_id', 'activity_id', 'is_read', 'file', 'file_name', 'message'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }


    public function user()
    {
        return $this->belongsTo(Employee::class, 'commenter_id');
    }
}
