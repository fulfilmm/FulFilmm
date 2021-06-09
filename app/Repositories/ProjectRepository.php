<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\DepartmentHead;
use App\Models\Project;
use App\Repositories\Contracts\DepartmentContract;
use App\Repositories\Contracts\ProjectContract;
use Illuminate\Database\Eloquent\Builder;

class ProjectRepository extends BaseRepository implements ProjectContract
{

    public function model()
    {
        return Project::class;
    }

    public function getProjectsWithTasks($project_id)
    {
        return $this->model->with('projectTasks')
             ->withCount(['projectTasks as task_done' => function (Builder $q) {
        $q->where('status', 1);
    }])
        ->withCount(['projectTasks as total_tasks'])
        ->find($project_id);
    }
}
