<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $customers)
    {
        foreach ($customers as $customer) {
            $company_id = Company::where('name', $customer['company'])->first()->id;
            Customer::create([
                'name' => $customer['name'],
                'phone' => $customer['phone'],
                'email' => $customer['email'],
                'address' => $customer['address'],
                'gender'=>$customer['gender'],
                'emp_id'=>Auth::guard('employee')->user()->id,
                'customer_type'=>'Customer',
                'company_id' => $company_id
            ]);
        }
    }
}
