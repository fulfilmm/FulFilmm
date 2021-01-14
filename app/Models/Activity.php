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
        'title', 'employee_id', 'report_to_employee_id', 'is_acknowledged'
    ];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo

    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function report_to_employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'report_to_employee_id');
    }

    public function activity_tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ActivityTask::class, 'activity_id');
    }
}
