<?php

namespace App\Repositories;

use App\Models\ProjectTask;
use App\Repositories\Contracts\ProjectTaskContract;

class ProjectTaskRepository extends BaseRepository implements ProjectTaskContract
{
    public function model()
    {
        return ProjectTask::class;
    }

}
