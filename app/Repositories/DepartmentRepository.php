<?php
namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentContract;

class DepartmentRepository extends BaseRepository implements DepartmentContract
{

    public function model()
    {
        return Department::class;
    }
}
