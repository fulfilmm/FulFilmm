<?php

namespace App\Imports;

use App\Models\ProductVariations;
use App\Models\Stock;
use App\Models\Warehouse;
use http\Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
//        dd($collection);
        foreach ($collection as $stock){
            $product=ProductVariations::with('product')->where('product_code',$stock['product_code'])->first();
            $warehouse=Warehouse::where('warehouse_id',$stock['warehouseid'])->first();
           try {
               $stock=Stock::where('variant_id',$product->id)->first();
             if($stock!=null){
                 $stock->stock_balance=$stock->stock_balance + $stock['qty'];
                 $stock->available=$stock->available + $stock['qty'];
                 $stock->update();

             }else{
                 $data['variant_id'] = $product->id;
                 $data['product_name'] = $product->product->name;
                 $data['warehouse_id'] = $warehouse->id;
                 $data['stock_balance'] = $stock['qty'];
                 $data['available'] = $stock['qty'];
                 Stock::create($data);
             }
           }catch (Exception $e){
               return redirect(route('stocks'))->with('error',$e->getMessage());
           }
        }
    }
}
