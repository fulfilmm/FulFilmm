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
//        dd($request);
        $main_product=ProductVariations::with('product')->where('id',$request['variantion_id'])->first();
        $all_qty=ProductStockBatch::where('warehouse_id',$request['warehouse_id'])->where('product_id',$request['variantion_id'])
            ->get();
        $sum_price=0;
        $total_qty=0;
        foreach ($all_qty as $item){
            $sum_price+=$item->qty * $item->purchase_price;
            $total_qty+=$item->qty;
        }
        $sum_price+=$request['qty']*$request['valuation'];
        $total_qty+=$request['qty'];
        $cos_of_sale=$sum_price/$total_qty;
//        dd($sum_price,$total_qty);
        $last_batch= ProductStockBatch::orderBy('id', 'desc')->where('product_id',$request['variantion_id'])->where('branch_id',$request['branch_id'])->first();


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
        $batch['alert_month']=$request['alert_month']??null;
        $batch['warehouse_id']=$request['warehouse_id'];
        $batch['branch_id']=$request['branch_id'];
        ProductStockBatch::create($batch);
        $stockin=new StockIn();
//        dd($request);
        $stockin->variantion_id=$request['variantion_id'];
        $stockin->emp_id=Auth::guard('employee')->user()->id;
        $stockin->supplier_id=$request['supplier_id'];
        $stockin->qty=$request['qty'];
        $stockin->warehouse_id=$request['warehouse_id'];
        $stockin->binlookup_id=$request['bin_id']??null;
        $stockin->branch_id=$request['branch_id'];
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
            $new_stock->product_name=$main_product->product->name;//ပြန်ဖြုတ်ရန်
            $new_stock->product_id=$main_product->product_id;
            $new_stock->variant_id=$request['variantion_id'];
            $new_stock->warehouse_id=$request['warehouse_id'];
            $new_stock->stock_balance=$request['qty']??0;
            $new_stock->available=$request['qty']??0;
            $new_stock->alert_qty=$request['alert_qty']??0;
            $new_stock->cos=$cos_of_sale;
            $new_stock->branch_id=$request['branch_id'];
            $new_stock->product_location=$request['product_location']??null;
            $new_stock->save();
        }else{
            $stock->stock_balance=$stock->stock_balance + $request['qty']??0;
            $stock->available=$stock->available+$request['qty']??0;
            $stock->cos=$cos_of_sale;
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
        $stock_transaction->contact_id=$request['supplier_id'];
        $stock_transaction->emp_id=Auth::guard('employee')->user()->id;
        $stock_transaction->creator_id=Auth::guard('employee')->user()->id;
        $stock_transaction->purchase_price=$request['valuation']??0;
        $stock_transaction->sale_value=$request['valuation']* $request['qty'];
        $stock_transaction->qty=$request['qty'];
        $stock_transaction->branch_id=$request['branch_id'];
        $stock_transaction->type="Stock In";
        $stock_transaction->save();

    }
}
