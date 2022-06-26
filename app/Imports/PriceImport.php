<?php

namespace App\Imports;

use App\Models\product_price;
use App\Models\ProductVariations;
use App\Models\Region;
use App\Models\SellingUnit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PriceImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $price) {
            $product = ProductVariations::where('item_code', $price['item_code'])->first();
            $unit = SellingUnit::where('unit', $price['unit'])->first();
            $region = Region::where('name', $price['region'])->first();
            $sales_price['product_id'] = $product->id;
            $sales_price['unit_id'] = $unit->id;
            $sales_price['sale_type'] = $price['sales_type'];
            $sales_price['price'] = $price['price'];
            $sales_price['rule'] = $price['rule'];
            $sales_price['max'] = $price['max'] ?? null;
            $sales_price['min'] = $price['min'] ?? null;
            $sales_price['start_date'] = $price['start_date'] ?? null;
            $sales_price['end_date'] = $price['end_date'] ?? null;
            $sales_price['multi_price'] = $price['multiple_price'] == 'Yes' ? 1 : 0;
            $sales_price['region_id'] = $region->id;
            product_price::create($sales_price);
        }
    }
}
