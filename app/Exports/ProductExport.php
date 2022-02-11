<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $data = [];
    public $exceptKeys=['brand','category','sub_cat'];
    public function collection()
    {
        return $this->data;
    }
    public function __construct()
    {
        $this->data = product::with('brand','category','sub_cat')
            ->select('name','model_no','cat_id','sub_cat_id','brand_id','created_at')
            ->get();
    }
    public function headings(): array
    {
        $head=['Product Name','Model No.','Description','Main Category','Sub-Category','Brand','Created Date'];
        return $head;
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->model_no??'N/A',
            $product->description,
            $product->category->name??'N/A',
            $product->sub_cat->name??'N/A',
            $product->brand->name??'N/A',
            $product->created_at->toFormattedDateString()

        ];

    }


}
