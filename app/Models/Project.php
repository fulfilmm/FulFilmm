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

    public function projectTasks(){
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    public function task(){
        return $this->projectTasks()->where('keyword', 'normal');
    }

    public function taskCount(){
        return $this->task()->count();
    }

    public function proposed_budget(){
        return $this->projectTasks()->where('keyword', 'proposed_budget');
    }

    public function proposed_resource(){
        return $this->projectTasks()->where('keyword', 'proposed_resource');
    }


    public function leadedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'leader');
    }

    public function ownedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'owner');
    }

    public function proposedTo()
    {
        return $this->belongsTo(Employee::class, 'proposed_to');
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
