<?php
namespace App\Repositories;

use App\Models\ActivityTask;
use App\Repositories\Contracts\ActivityTaskContract;

class ActivityTaskRepository extends BaseRepository implements ActivityTaskContract
{

    public function model()
    {
        return ActivityTask::class;
    }
}
