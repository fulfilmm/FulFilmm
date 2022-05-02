<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductBrandImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as  $product) {
//            dd($product);
            $main_cat=products_category::where('name',$product['main_category'])->first();
            $sub_cat=products_category::where('name',$product['sub_category'])->first();
            $brand=Brand::where('name',$product['brand'])->first();
            $product_data['name']=$product['product_name'];
            $product_data['description']=$product['description'];
            $product_data['model_no']=$product['model_no'];
            $product_data['cat_id']=$main_cat->id??null;
            $product_data['sub_cat_id']=$sub_cat->id??null;
            $product_data['brand_id']=$brand->id??null;

            // dd($employee_data);
            product::create($product_data);
        }
    }
}
