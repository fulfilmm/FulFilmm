<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'due_date', 'assigned_by', 'creator_department_id'
    ];


    public function assignment_tasks()
    {
        return $this->hasMany(AssignmentTask::class, 'assignment_id');
    }

    public function assigned_employees()
    {
        return $this->belongsToMany(Employee::class, 'assignment_employee');
    }

    public function assigned_groups()
    {
        return $this->belongsToMany(Group::class, 'assignment_group');
    }

    public function assignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }
}
