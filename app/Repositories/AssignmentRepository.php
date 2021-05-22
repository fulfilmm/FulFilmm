<?php
namespace App\Repositories;

use App\Models\Assignment;
use App\Repositories\Contracts\AssignmentContract;

class AssignmentRepository extends BaseRepository implements AssignmentContract
{
    public function model()
    {
        return Assignment::class;
    }

    public function getAssignmentsWithTasks($assignment_id)
    {
        return $this->model->with('assignment_tasks')->find($assignment_id);
    }
}