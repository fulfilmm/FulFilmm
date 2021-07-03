<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\DepartmentHead;
use App\Models\Project;
use App\Repositories\Contracts\DepartmentContract;
use App\Repositories\Contracts\ProjectContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProjectRepository extends BaseRepository implements ProjectContract
{

    public function model()
    {
        return Project::class;
    }

    public function getProjectsWithTasks($project_id)
    {
        return $this->model
        ->whereHas('task', function(Builder $query){
            $query->whereHas('assigned_employees', function(Builder $query){
                $query->where('employee_id', Auth::id());
            });
        })
        ->orWhereHas('ownedBy', function(Builder $query){
            $query->where('owner', Auth::id());
        })
        ->orWhereHas('creator', function(Builder $query){
            $query->where('created_by', Auth::id());    
        })
        // ->orWhereHas('leadedBy', function(Builder $query){
        //     $query->where('leader', Auth::id());    
        // })
        // ->orWhereHas('proposedTo', function(Builder $query){
        //     $query->where('proposed_to', Auth::id());    
        // })
        ->withCount(['projectTasks as task_done' => function (Builder $q) {
        $q->where('status', 1);
        }])
        ->withCount(['projectTasks as total_tasks'])
        ->find($project_id);
    }
}
