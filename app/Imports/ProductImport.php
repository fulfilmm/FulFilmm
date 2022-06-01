<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\product;
use App\Models\products_category;
use App\Models\ProductVariations;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as  $product) {
//            dd($product);
           $exists_product=product::where('product_code',$product['product_code'])->first();
           if($exists_product==null){
               $main_cat=products_category::where('name',$product['main_category'])->first();
               $sub_cat=products_category::where('name',$product['sub_category'])->first();
               $brand=Brand::where('name',$product['brand'])->first();
               $product_data['name']=$product['product_name'];
               $product_data['description']=$product['description'];
               $product_data['model_no']=$product['model_no'];
               $product_data['product_code']=$product['product_code'];
               $product_data['cat_id']=$main_cat->id??null;
               $product_data['sub_cat_id']=$sub_cat->id??null;
               $product_data['brand_id']=$brand->id??null;

               // dd($employee_data);
               $p=product::create($product_data);
               $variant['item_code']=$product['item_code'];
               $variant['product_id']=$p->id;
               $variant['product_name']=$p->name;
               $variant['enable']=0;
               $variant['variant']=$product['variant'];
               $variant['additional_price']=$product['additional_price']??0;
               ProductVariations::create($variant);
           }else{
               $variant['item_code']=$product['item_code'];
               $variant['product_id']=$exists_product->id;
               $variant['product_name']=$exists_product->name;
               $variant['enable']=0;
               $variant['variant']=$product['variant'];
               $variant['additional_price']=$product['additional_price']??0;
               ProductVariations::create($variant);
           }


        }
    }
}
