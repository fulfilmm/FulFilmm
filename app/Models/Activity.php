<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'title', 'employee_id', 'report_to_employee_id', 'customer_id', 'is_acknowledged'
    ];

    public function activity_tasks()
    {
        return $this->hasMany(ActivitiyTask::class, 'activity_id');
    }
}
