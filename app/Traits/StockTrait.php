<?php
namespace App\Traits;

use App\Models\ProductStockBatch;
use App\Models\ProductVariations;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;

trait StockTrait
{
    public function stockin($request){
        $main_product=ProductVariations::with('product')->where('id',$request['variantion_id'])->first();
        $last_batch= ProductStockBatch::orderBy('id', 'desc')->where('product_id',$request['variantion_id'])->first();

        if ($last_batch != null) {
            $last_batch->batch_no++;
            $batch_no = $last_batch->batch_no;
        } else {
            $batch_no = "Batch-00001";
        }
        $batch['product_id']=$request['variantion_id'];
        $batch['batch_no']=$batch_no;
        $batch['supplier_id']=$request['supplier_id'];
        $batch['qty']=$request['qty'];
        $batch['purchase_price']=$request['valuation']??0;
        $batch['exp_date']=$request['exp_date']??null;
        $batch['warehouse_id']=$request['warehouse_id'];
        ProductStockBatch::create($batch);
        $stockin=new StockIn();
//        dd($request);
        $stockin->variantion_id=$request['variantion_id'];
        $stockin->emp_id=Auth::guard('employee')->user()->id;
        $stockin->supplier_id=$request['supplier_id'];
        $stockin->qty=$request['qty'];
        $stockin->save();

       if(isset($request['valuation'])){
           if($request['valuation']!=null){
               $main_product->purchase_price=$request['valuation']??0;
               $main_product->update();
           }
       }
        $stock=Stock::where('variant_id',$request['variantion_id'])->where('warehouse_id',$request['warehouse_id'])->first();
        if($stock==null){
            $new_stock=new Stock();
            $new_stock->product_name=$main_product->product->name;
            $new_stock->variant_id=$request['variantion_id'];
            $new_stock->warehouse_id=$request['warehouse_id'];
            $new_stock->stock_balance=$request['qty']??0;
            $new_stock->available=$request['qty']??0;
            $new_stock->alert_qty=$request['alert_qty']??0;
            $new_stock->product_location=$request['product_location']??null;
            $new_stock->save();
        }else{
            $stock->stock_balance=$stock->stock_balance + $request['qty']??0;
            $stock->available=$stock->available+$request['qty']??0;
            $stock->update();
            $product_variant=ProductVariations::where('id',$request['variantion_id'])->first();
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
