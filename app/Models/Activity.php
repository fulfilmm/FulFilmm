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

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('employee', 'employee_id');
    }

    public function report_to_employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('employee', 'report_to_employee_id');
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('customer');
    }

    public function activity_tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ActivitiyTask::class, 'activity_id');
    }
}
