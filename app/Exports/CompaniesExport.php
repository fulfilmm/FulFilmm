<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompaniesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data = [];
    public $exceptKeys = ['logo', 'data', 'user_company'];
    public function __construct()
    {
        $this->data = Company::all();
    }
    public function collection()
    {

        return Company::all();
    }

    public function headings(): array
    {
        $keys = collect($this->data->first())->except($this->exceptKeys)->keys()->toArray();
        return $keys;
    }


    public function map($company): array
    {
        $company_array = collect($company)->except($this->exceptKeys)->toArray();
        $company_array['parent_company'] = $company->parentCompany->name ?? '';
        $company_array['parent_company_2'] = $company->parentCompany2->name ?? '';

        return $company_array;
    }
}
