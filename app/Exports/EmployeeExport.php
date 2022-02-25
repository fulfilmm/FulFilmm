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

    public function __construct($start_date,$end_date)
    {
        $this->data = Employee::with('reportperson','branch')
            ->whereBetween('created_at',[$start_date,$end_date])->get();

    }

    public function collection()
    {
        return $this->data;
    }
    public function map($employee): array
    {
        return [
            $employee->empid,
            $employee->name,
            $employee->phone,
            $employee->email,
            $employee->work_phone,
            $employee->join_date,
            $employee->reportperson->name??'N/A',
            $employee->department->name,
            $employee->role->name??'N/A',
            $employee->branch->name??'N/A',
            $employee->created_at

        ];
    }

    public function headings(): array
    {
        $head=['Empid','Name','Phone','Email','Work Phone','Join Date','Report Person','Department','Role','Office Branch','Created Date'];
        return $head;
    }
}
