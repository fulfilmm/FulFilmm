<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompanyImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        foreach ($collection as $company) {
            // dd($company);
            $company_data = $company->except('id', 'parent_company', 'parent_company_2')->toArray();
            $company_data['use_company'] = 0;

            Company::create($company_data);
        }
    }
}
