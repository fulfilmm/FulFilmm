<?php
namespace App\Repositories;

use App\Models\Assignment;
use App\Repositories\Contracts\AssignmentContract;

class AssignmentRepository extends BaseRepository implements AssignmentContract
{
    public function model()
    {
        return Assignment::class;
    }
}