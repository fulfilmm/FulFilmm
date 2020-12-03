<?php

namespace App\Exports;

use App\Models\Employee;
use App\User;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    public $data = [];
    public $exceptKeys = ['department_id'];

    public function __construct()
    {
        $this->data = Employee::get();
    }

    public function collection()
    {
        return $this->data;
    }
    public function map($employee): array
    {
        $employee_array = collect($employee)->except($this->exceptKeys)->toArray();
        $employee_array['department'] = $employee->department->name;
        return $employee_array;
    }

    public function headings(): array
    {
        $keys =  collect($this->data->first())->except($this->exceptKeys)->keys()->toArray();
        array_push($keys, 'department');
        return $keys;
    }
}
