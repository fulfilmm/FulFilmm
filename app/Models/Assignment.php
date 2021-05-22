<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'date', 'assigned_by', 'creator_department_id'
    ];

    public function assigned_employees()
    {
        $this->belongsToMany(Employee::class, 'assignment_employee');
    }

    public function assignedBy()
    {
        $this->belongsTo(Employee::class, 'assigned_by');
    }
}
