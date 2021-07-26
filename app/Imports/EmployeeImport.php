<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Employee;
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
        // dd($collection);
        foreach ($collection as  $employee) {
            // dd($employee);
            $employee_data = $employee->except('id', 'department')->toArray();
            $employee_data['password'] = bcrypt('123123');
            $employee_data['can_login'] = 1;
            $employee_data['department_id'] = Department::where('name', $employee['department'])->first()->id;
            // dd($employee_data);
            Employee::create($employee_data);
        }
    }
}
