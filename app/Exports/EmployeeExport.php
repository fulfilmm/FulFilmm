<?php

namespace App\Exports;

use App\Models\Employee;
use App\User;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    public $data = [];


    public function __construct()
    {
        $this->data = Employee::all();
    }

    public function collection()
    {
        return $this->data;
    }



    public function headings(): array
    {

        return collect($this->data->first())->keys()->toArray();
    }
}
