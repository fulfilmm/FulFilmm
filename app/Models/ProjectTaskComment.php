<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTaskComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'commenter_id', 'project_task_id', 'is_read', 'file', 'file_name', 'message'
    ];

    public function projectTask()
    {
        return $this->belongsTo(ProjectTask::class, 'project_task_id');
    }

    public function user()
    {
        return $this->belongsTo(Employee::class, 'commenter_id');
    }

}
