<?php

namespace App\Repositories;

use App\Models\Assignment;
use App\Repositories\Contracts\AssignmentContract;
use Illuminate\Database\Eloquent\Builder;

class AssignmentRepository extends BaseRepository implements AssignmentContract
{
    public function model()
    {
        return Assignment::class;
    }

    public function getAssignmentsWithTasks($assignment_id)
    {
        return $this->model->with('assignment_tasks')
            ->withCount(['assignment_tasks as task_done' => function (Builder $q) {
                $q->where('status', 1);
            }])
            ->withCount(['assignment_tasks as total_tasks'])
            ->find($assignment_id);
    }

}
