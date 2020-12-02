<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerExport implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;
    public function __construct()
    {
        $this->data = Customer::with('company')
                        ->select('name', 'phone', 'email', 'address', 'company_id', 'created_at')
                        ->get();
    }
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return collect($this->data->first())->keys()->except(4)->toArray();
    }

    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->phone,
            $customer->email,
            $customer->address,
            $customer->created_at,
            $customer->company->name
        ];
    }
}
