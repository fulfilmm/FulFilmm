<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Employee;
use App\Models\OfficeBranch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
//         dd($collection[0]']);
        foreach ($collection as  $employee) {
//             dd($employee);
            $office=OfficeBranch::where('name',$employee['office_branch'])->first();
            $employee_data['empid']=$employee['empid'];
            $employee_data['name']=$employee['name'];
            $employee_data['email']=$employee['email'];
            $employee_data['phone']=$employee['phone'];
            $employee_data['office_branch_id']=$office->id??null;
            $employee_data = $employee->except('id', 'department')->toArray();
            $employee_data['password'] = bcrypt('123123');
            $employee_data['can_login'] = 1;
            $employee_data['can_post_assignments']=1;
            $employee_data['department_id'] = Department::where('name', $employee['department'])->first()->id;
            // dd($employee_data);
            $emp=Employee::create($employee_data);
            $emp->assignRole($employee['role']);
        }
    }
}
