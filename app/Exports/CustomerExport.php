<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;
    public function __construct()
    {
        $this->data = Customer::all();
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
