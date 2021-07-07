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

        $user_id = Auth::id();

        return $this->model
        ->whereHas('task', function(Builder $query) use ($user_id){
            $query->whereHas('assigned_employees', function(Builder $query) use ($user_id){
                $query->where('employee_id', $user_id);
            });
        })
        ->orWhere('leader', $user_id)
        ->orWhere('proposed_to', $user_id)
        ->orWhere('owner', $user_id)
        ->orWhere('created_by', $user_id)

        ->withCount(['task as task_done' => function (Builder $q) {
        $q->where('status', 1);
        }])
        ->withCount(['task as total_tasks'])
        ->findorFail($project_id);
    }
}
