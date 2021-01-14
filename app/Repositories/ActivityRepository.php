<?php
namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Contracts\ActivityContract;

class ActivityRepository extends BaseRepository implements ActivityContract
{

    public function model()
    {
        return Activity::class;
    }

    public function activityWithTasks($id)
    {
        return $this->model->with('activity_tasks')->find($id);
    }
}
