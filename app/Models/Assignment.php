<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

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

    public function assignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }
}
