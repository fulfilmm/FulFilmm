<?php
namespace App\Repositories;

use App\Models\AssignmentTask;
use App\Repositories\Contracts\AssignmentTaskContract;

class AssignmentRepository extends BaseRepository implements AssignmentTaskContract
{
    public function model()
    {
        return AssignmentTask::class;
    }
}