<?php
namespace App\Repositories\Contracts;

interface ActivityContract
{
    public function activityWithTasks($id);
}
