<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\DepartmentHead;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $departments)
    {
        foreach ($departments as $department) {
            $parent_department_id = Department::where('name',$department['parent_department'])->first()->id;

            $new_dept = Department::create([
                'name' => $department['name'],
                'parent_department' => $parent_department_id,
                'address' => $department['address'],
            ]);

            if (isset($department['department_head'])) {
                $department_head_id = Employee::where('name', $department['department_head'])->first()->id;
                DepartmentHead::create([
                    'department_id' => $new_dept->id,
                    'employee_id' => $department_head_id
                ]);
            };

        }
    }
}
