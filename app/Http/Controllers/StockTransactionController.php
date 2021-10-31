<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\ProductVariations;
use App\Models\Stock;
use App\Models\StockOut;
use App\Models\StockTransaction;
use App\Models\StockTransferRecord;
use App\Models\Warehouse;
use App\Traits\StockTrait;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    use StockTrait;

    public function index()
    {
        $stock_transactions = StockTransaction::with('stockin', 'stockout','variant')->get();
        $stocks = Stock::all();
        return view('stock.index', compact('stock_transactions', 'stocks'));
    }

    public function stockin_form()
    {
        $products = ProductVariations::with('product')->get();
        $customers = Customer::where('customer_type', 'Supplier')->get();
        $warehouses = Warehouse::all();
        return view('stock.stockin', compact('products', 'customers', 'warehouses'));
    }

    public function stockout_form()
    {
        $emps = Employee::all();
        $products = ProductVariations::with('product')->get();
        $customers = Customer::where('customer_type', 'Lead')->where('status', 'qualified')->get();
        $couriers = Customer::where('customer_type', 'Courier')->get();
        $warehouses = Warehouse::all();
        return view('stock.stockout', compact('emps', 'products', 'customers', 'warehouses','couriers'));
    }

    public function stock_in(Request $request)
    {
        $this->validate($request, ['qty' => 'required']);
//        dd($request->all());
        $data = ['qty' => $request->qty,
            'warehouse_id' => $request->warehouse_id,
            'supplier_id' => $request->supplier_id,
            'variantion_id' => $request->variation_id
        ];
//        dd($data);
        $this->stockin($data);
        return redirect(route('stocks.index'));
    }

    public function stockout(Request $request)
    {
//        dd($request->all());
        $this->validate($request, ['qty' => 'required', 'customer_id' => 'required']);
        $stock=Stock::where('variant_id',$request->variantion_id)->where('warehouse_id',$request->warehouse_id)->first();
        if($stock->stock_balance < $request->qty){
            return redirect()->back()->with('warning','Not Enough Product!Maximum Product is '.$stock->stock_balance);
        }else {
            $stock_out = new StockOut();
            $stock_out->variantion_id = $request->variantion_id;
            $stock_out->emp_id = $request->emp_id;
            $stock_out->customer_id = $request->customer_id;
            $stock_out->qty = $request->qty;
            $stock_out->save();
            $main_product = ProductVariations::with('product')->where('id', $request->variantion_id)->first();
            $stock_transaction = new StockTransaction();
            $stock_transaction->product_name = $main_product->product->name;
            $stock_transaction->stock_out = $stock_out->id;
            $stock_transaction->warehouse_id = $request->warehouse_id;
            $stock_transaction->variant_id=$request->variantion_id;
            $stock_transaction->type = 0;
            $stock_transaction->balance=$stock->stock_balance - $request['qty'];
            $stock_transaction->save();
            $stock->stock_balance = $stock->stock_balance - $request['qty'];
            $stock->update();
            $product_variant = ProductVariations::where('id', $request['variantion_id'])->first();
            $product_variant->qty = $product_variant->qty - $request['qty'];
            $product_variant->update();
            return redirect(route('stocks.index'));
        }
    }
    public function stock(){
        $stocks=Stock::with('warehouse','variant')->get();
//        dd($stocks);
        return view('stock.stock',compact('stocks'));
    }
    public function transfer(){
        $warehouse=Warehouse::all()->pluck('name','id')->all();
        $products=ProductVariations::with('product')->get();
        return view('stock.stocktransfer',compact('warehouse','products'));
    }
    public function stock_transfer(Request $request){
//        dd('hello');
//       dd($request->all());
       if($request->transfer_warehouse_id==$request->current_warehouse_id){
           return redirect()->back()->with('warning','Does not need to transfer in same warehouse');
       }else{
           $stock=Stock::where('variant_id',$request->variantion_id)->where('warehouse_id',$request->current_warehouse_id)->first();
           if($stock->stock_balance < $request->qty){
               return redirect()->back()->with('warning','Not Enough Product!Maximum Product is '.$stock->stock_balance);
           }else {
//               dd($request->all());
               $product_exist=Stock::where('variant_id',$request->variantion_id)->where('warehouse_id',$request->transfer_warehouse_id)->first();
//              dd('here');
               if($product_exist==null) {
//                   dd('inner create stock');
                   $new_stock = new Stock();
                   $new_stock->product_name=$stock->product_name;
                   $new_stock->variant_id=$request->variantion_id;
                   $new_stock->warehouse_id=$request->transfer_warehouse_id;
                   $new_stock->stock_balance=$request->qty;
                   $new_stock->save();
               }else{
                   $product_exist->stock_balance=$product_exist->stock_balance + $request->qty;
                   $product_exist->update();
               }
            $transfer_record=new StockTransferRecord();
               $transfer_record->product_name=$stock->product_name;
               $transfer_record->variant_id=$request->variantion_id;
               $transfer_record->from_warehouse=$request->current_warehouse_id;
               $transfer_record->to_warehouse=$request->transfer_warehouse_id;
               $transfer_record->qty=$request->qty;
               $transfer_record->save();
               $stock->stock_balance=$stock->stock_balance- $request->qty;
               $stock->update();
           }

           return redirect(route('transfer.index'));
       }
    }
    public function transfer_record(){
        $transfers=StockTransferRecord::with('variant','from','to')->get();
//        dd($transfers);
        return view('stock.transfer_record',compact('transfers'));
    }

}
