<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepartmentExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct()
    {
        $this->data = Department::with('parent_dept')
                        ->select('name', 'parent_department', 'address', 'created_at', 'updated_at')
                        ->get();
    }
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return collect($this->data->first())->keys()->except(5)->toArray();
    }

    public function map($department): array
    {
        return [
            $department->name,
            $department->parent_dept->name ?? '-',
            $department->address,
            $department->created_at
        ];
    }
}
