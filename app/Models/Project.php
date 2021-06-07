<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'created_by',
        'proposed_to',
        'leader',
        'owner',
        'start_date',
        'end_date',
        'priority',
        'status',
        'description',
    ];

//    public function employees()
//    {
//        return $this->belongsToMany(Employee::class, 'groups_employees', 'group_id', 'employee_id');
//    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
