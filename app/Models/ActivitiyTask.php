<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitiyTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title', 'activity_id'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
