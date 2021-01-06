<?php
namespace App\Repositories\Contracts;

Interface DepartmentContract
{

    public function parentDepartments();

    public function getDepartmentWithHead($department_id);

    public function assignDepartmentHead($department_id, $employee_id);
}
