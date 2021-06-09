<?php
namespace App\Repositories\Contracts;

Interface ProjectContract
{
    public function getProjectsWithTasks($project_id);
}
