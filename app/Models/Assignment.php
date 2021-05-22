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
        return $this->belongsToMany(Employee::class, 'assignment_employee');
    }

    public function assigned_by()
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }
}
