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
        return $this->model->with('activity_tasks')->findOrFail($id);
    }
    
    public function acknowledgeActivity($activity_id)
    {
        $activity = $this->model->find($activity_id);
        $activity->is_acknowledged = 1;
        $activity->save();
        return $activity;
    }
    
    public function addCoOwners($activity, $employee_ids)
    {
        foreach ($employee_ids as $employee_id) {
            $activity->co_owners()->create(['employee_id' => $employee_id]);
        }
        return $activity;
    }
    
    public function syncCoOwners($activity, $employee_ids)
    {
        $activity->co_owners()->delete();
        
        foreach ($employee_ids as $employee_id) {
            $activity->co_owners()->create(['employee_id' => $employee_id]);
        }
        return $activity;
    }
    
    
}
