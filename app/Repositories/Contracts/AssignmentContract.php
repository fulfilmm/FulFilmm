<?php
namespace App\Repositories\Contracts;

interface AssignmentContract
{
    public function getAssignmentsWithTasks($assignment_id);
}