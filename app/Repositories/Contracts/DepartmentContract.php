<?php
namespace App\Repositories\Contracts;

Interface DepartmentContract
{

    public function parentDepartments();

    public function assignDepartmentHead($department_id, $employee_id);
}
