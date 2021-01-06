<?php
namespace App\Repositories;

use App\Models\ActivitiyTask;
use App\Repositories\Contracts\ActivityTaskContract;

class ActivityTaskRepository extends BaseRepository implements ActivityTaskContract
{

    public function model()
    {
        return ActivitiyTask::class;
    }
}
