<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title', 'activity_id','status'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
