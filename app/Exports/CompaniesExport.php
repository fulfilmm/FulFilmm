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
    public function __construct($start_date,$end_date)
    {
        $this->data = Company::whereBetween('created_at',[$start_date,$end_date])
            ->select('name','email','phone','address','business_type','web_link','facebook_page','linkedin','created_at')
            ->get();
    }
    public function collection()
    {

        return $this->data;
    }

    public function headings(): array
    {
        return collect($this->data->first())->keys()->except(9)->toArray();
    }


    public function map($company): array
    {

        return [
            $company->name,
            $company->email,
            $company->phone,
            $company->address,
            $company->business_type,
            $company->web_link,
            $company->facebook_page,
            $company->linkedin,
            $company->created_at,

        ];
    }
}
