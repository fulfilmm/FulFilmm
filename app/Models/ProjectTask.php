<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

    protected $table = 'project_tasks';

    protected $fillable = [
        'name', 'project_id', 'keyword', 'duration', 'due_date', 'progress', 'status'
    ];

    public function assigned_employees()
    {
        return $this->belongsToMany(Employee::class, 'assignment_employee');
    }
}
