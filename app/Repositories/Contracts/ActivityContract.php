<?php
namespace App\Repositories\Contracts;

interface ActivityContract
{
    public function activityWithTasks($id);

    public function acknowledgeActivity($activity_id);

    public function addCoOwners($activity, $employee_ids);
}
