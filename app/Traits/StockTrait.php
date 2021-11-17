<?php
namespace App\Traits;

use App\Models\ProductVariations;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;

trait StockTrait
{
    public function stockin($request){
//        dd($request['variantion_id']);
        $main_product=ProductVariations::with('product')->where('id',$request['variantion_id'])->first();
        $stockin=new StockIn();
        $stockin->variantion_id=$request['variantion_id'];
        $stockin->emp_id=Auth::guard('employee')->user()->id;
        $stockin->supplier_id=$request['supplier_id'];
        $stockin->qty=$request['qty'];
        $stockin->save();
        $stock=Stock::where('variant_id',$request['variantion_id'])->where('warehouse_id',$request['warehouse_id'])->first();
        if($stock==null){
            $new_stock=new Stock();
            $new_stock->product_name=$main_product->product->name;
            $new_stock->variant_id=$request['variantion_id'];
            $new_stock->warehouse_id=$request['warehouse_id'];
            $new_stock->stock_balance=$request['qty'];
            $new_stock->available=$request['qty'];
            $new_stock->alert_qty=$request['alert_qty'];
            $new_stock->save();
        }else{
            $stock->stock_balance=$stock->stock_balance + $request['qty'];
            $stock->update();
            $product_variant=ProductVariations::where('id',$request['variantion_id'])->first();
            $product_variant->qty=$product_variant->qty + $request['qty'];
            $product_variant->update();
        }
        $stock_transaction=new StockTransaction();
//        dd($request['variantion_id']);
        $stock_transaction->product_name=$main_product->product->name;
        $stock_transaction->stock_in=$stockin->id;
        $stock_transaction->variant_id=$request['variantion_id'];
        $stock_transaction->warehouse_id=$request['warehouse_id'];
        $stock_transaction->balance=$stock->stock_balance??0 + $request['qty'];
        $stock_transaction->type=1;
        $stock_transaction->save();

    }
}
