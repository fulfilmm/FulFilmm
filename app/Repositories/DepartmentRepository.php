<?php
namespace App\Repositories;

use App\Models\Department;
use App\Models\DepartmentHead;
use App\Repositories\Contracts\DepartmentContract;

class DepartmentRepository extends BaseRepository implements DepartmentContract
{

    public function model()
    {
        return Department::class;
    }

    public function parentDepartments()
    {
        return $this->model->whereNull('parent_department')->get();
    }

    public function getDepartmentWithHead($department_id)
    {
        return $this->model->with('departmentHeads')->find($department_id);
    }

    public function assignDepartmentHead($department_id, $employee_id)
    {
        DepartmentHead::create([
            'department_id'=> $department_id,
            'employee_id' => $employee_id
        ]);
    }
}
