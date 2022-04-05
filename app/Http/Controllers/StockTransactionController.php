<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Exports\StockExport;
use App\Imports\StockImport;
use App\Models\BinLookUp;
use App\Models\Customer;
use App\Models\DamagedProduct;
use App\Models\EcommerceProduct;
use App\Models\Employee;
use App\Models\Freeofchare;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\product;
use App\Models\ProductReceiveItem;
use App\Models\ProductStockBatch;
use App\Models\ProductVariations;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockLeger;
use App\Models\StockOut;
use App\Models\StockTransaction;
use App\Models\StockTransferRecord;
use App\Models\StockUpdatedHistory;
use App\Models\Warehouse;
use App\Traits\NotifyTrait;
use App\Traits\StockTrait;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StockTransactionController extends Controller
{
    use StockTrait;
    use NotifyTrait;

    public function __construct()
    {
        $stock=Stock::with('variant')->get();
        $employees=Employee::all();

        foreach ($stock as $item){
            if($item->alert_qty >= $item->stock_balance){
                foreach ($employees as $emp){
                    $exit_noti=Notification::where('type',$item->id)->where('read_at',null)->where('notify_user_id',$emp->id)->first();
                    if($emp->role->name=='Stock Manager'&& $exit_noti==null){
                        $this->addnotify($emp->id,'stock not enough',$item->variant->product_name.'Only '.$item->stock_balance.' left in stock','stocks',null);
                    }
                }
            }
        }
    }

    public function index()
    {
        $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')->get();
        $stocks = Stock::all();
        $units=SellingUnit::all();
//        dd($stock_transactions);
        return view('stock.index', compact('stock_transactions', 'stocks','units'));
    }

    public function stockin_form()
    {
        $products = ProductVariations::with('product')->get();
//        dd($products);
        $customers = Customer::where('customer_type', 'Supplier')->get();
        $warehouses = Warehouse::all();
        $binlook=BinLookUp::all();
        return view('stock.stockin', compact('products', 'customers', 'warehouses','binlook'));
    }

    public function stockout_form()
    {
        $emps = Employee::all();
        $type=['Invoice','FOC','Donation','Simple','Guest','Damage','E-commerce Stock'];
        $main_product=product::all();
        $products = ProductVariations::with('product')->get();
        $customers =Customer::where('customer_type', 'Lead')->where('status', 'qualified')->get();
        $couriers = Customer::where('customer_type', 'Courier')->get();
        $warehouses = Warehouse::all();
        $invoice=Invoice::all()->pluck('invoice_id','id')->all();
        $units=SellingUnit::all();
        $batch=ProductStockBatch::all();
        return view('stock.stockout', compact('emps', 'units','products', 'customers', 'warehouses','couriers','type','invoice','main_product','batch'));
    }

    public function stock_in(Request $request)
    {
        $this->validate($request, [
            'qty' => 'required',
            'warehouse_id' => 'required',
            'supplier_id' => 'required',
            'product_id' =>'required' ,
            'purchase_price'=>'required',
        ]);
        $data = [
            'qty' => $request->qty,
            'warehouse_id' => $request->warehouse_id,
            'supplier_id' => $request->supplier_id,
            'variantion_id' => $request->product_id,
            'product_location'=>$request->product_location,
            'valuation'=>$request->purchase_price,
            'exp_date'=>$request->exp_date,
            'bin_id'=>$request->binlookup_id
        ];
//        dd($data);
        $this->stockin($data);
        if(isset($request->receive_id)){
            $product_receive_item=ProductReceiveItem::where('id',$request->receive_id)->first();
            $product_receive_item->is_stocked_in=1;
            $product_receive_item->update();
        }
        return redirect(route('stocks.index'));
    }

    public function stockout(Request $request)
    {
//        dd($request->all());
        $this->validate($request, ['qty' => 'required','type'=>'required','variantion_id'=>'required']);
        $stock=Stock::where('variant_id',$request->variantion_id)->where('warehouse_id',$request->warehouse_id)->first();
        $unit=SellingUnit::where('id',$request->sell_unit)->first();
        if($stock->stock_balance < ($request->qty*$unit->unit_convert_rate)){
            return redirect()->back()->with('warning','Not Enough Product!Maximum Product is '.$stock->stock_balance);
        }else {
            $data=[
                'qty'=>($request->qty*$unit->unit_convert_rate),
                'customer_id'=>$request->customer_id,
                'emp_id'=>$request->emp_id,
                'variantion_id'=>$request->variantion_id,
                'approver_id'=>$request->approver_id,
                'courier_id'=>$request->courier_id,
                'warehouse_id'=>$request->warehouse_id,
                'description'=>$request->description,
                'invoice_id'=>$request->invoice_id,
                'type'=>$request->type,
                'sell_unit'=>$request->sell_unit,
                'creator_id'=>Auth::guard('employee')->user()->id,
            ];
            StockOut::create($data);
            $this->addnotify($request->approver_id,'success','Request stock out to you.','stockout/index',Auth::guard('employee')->user()->id);
            return redirect(route('stock.out.index'));
        }
    }
    public function stockoutindex(){
        $stock=StockOut::with('variant','warehouse','emp','approver')->get();
        $units=SellingUnit::all();
        return view('stock.stockoutindex',compact('stock','units'));
    }
    public function stockfilter(Request $request){
//        dd($request->all());
        $stocks = Stock::all();
        $stock_transactions=StockTransaction::with('stockin', 'stockout','variant')->whereBetween('created_at',[Carbon::parse($request->start_date),Carbon::parse($request->end_date)])->get();
//        dd($stocks);
        $units=SellingUnit::all();
        return view('stock.index',compact('stock_transactions','stocks','units'));
    }
    public function approve($id){
        $stock_out=StockOut::with('variant')->where('id',$id)->where('approve',0)->first();
        if($stock_out->approver_id==Auth::guard('employee')->user()->id){
            $stock=Stock::where('variant_id',$stock_out->variantion_id)->where('warehouse_id',$stock_out->warehouse_id)->first();
           $current_bal=$stock->stock_balance;
            $main_product = ProductVariations::with('product')->where('id', $stock_out->variantion_id)->first();
            if($stock_out->type=='FOC'){
                $foc=new Freeofchare();
                $foc->variant_id=$stock_out->variantion_id;
                $foc->qty=$stock_out->qty;
                $foc->issuer_id=$stock_out->emp_id;
                $foc->description=$stock_out->description;
                $foc->save();
            }elseif($stock_out->type=='Damage') {
                $data = ['warehouse_id' => $stock_out->warehouse_id, 'emp_id' => $stock_out->emp_id, 'qty' => $stock_out->qty, 'variant_id' => $stock_out->variantion_id];
                DamagedProduct::create($data);
            }elseif ($stock_out->type=='E-commerce Stock'){

               $exists_ecommerce_stock=EcommerceProduct::where('product_id',$stock_out->variantion_id)->first();
                if($exists_ecommerce_stock==null){
                    $product=product::with('brand','category')->where('id',$stock_out->variant->product_id)->first();
                    $ecommerce_stock=new EcommerceProduct();
                    $ecommerce_stock->product_id=$stock_out->variantion_id;
                    $ecommerce_stock->name=$stock_out->variant->product_name;
                    $ecommerce_stock->qty=$stock_out->qty;
                    $ecommerce_stock->brand=$product->brand->name??'';
                    $ecommerce_stock->save();
                }else{
                    $exists_ecommerce_stock->qty=$exists_ecommerce_stock->qty + $stock_out->qty;
                    $exists_ecommerce_stock->update();
                }
            }

            $stock_out->approve=1;
            $stock_out->update();
            $batches=ProductStockBatch::where('product_id',$stock_out->variantion_id)->get();
            $remaing=$stock_out->qty;
            foreach ($batches as $batch){
               if($batch->qty!=0){
                   if($batch->qty >= $remaing){
                       $batch->qty=$batch->qty - $remaing;
                       $qty=$remaing;
                       $remaing=0;
                       $batch->update();
                       $product=ProductStockBatch::all();
                       $total=0;
                       foreach ($product as $item){
                           $valuation=$item->qty*$item->purchase_price??0;
                           $total+=$valuation;
                       }
                       $stock_transaction = new StockTransaction();
                       $stock_transaction->product_name = $main_product->product->name;
                       $stock_transaction->stock_out = $stock_out->id;
                       $stock_transaction->warehouse_id = $stock_out->warehouse_id;
                       $stock_transaction->variant_id=$stock_out->variantion_id;
                       $stock_transaction->contact_id=$stock_out->customer_id;
                       $stock_transaction->qty=$qty;
                       $stock_transaction->type ="Stock Out";
                       $stock_transaction->emp_id=$stock_out->emp_id;
                       $stock_transaction->creator_id=$stock_out->creator_id;
                       $stock_transaction->balance=$stock->stock_balance-$qty;
                       $stock_transaction->purchase_price=$batch->purchase_price;
                       $stock_transaction->sale_value=$qty*$batch->purchase_price;
                       $stock_transaction->inventory_value=$total;
                       $stock_transaction->save();
                       if($stock_out->type=='Invoice'){
                           $stock->stock_balance = $stock->stock_balance - $qty;
                       }else{
                           $stock->available=$stock->available - $qty;
                           $stock->stock_balance = $stock->stock_balance - $qty;
                       }
                       $stock->update();
                   }else{
                       $qty=$batch->qty;
                       $remaing=$remaing - $batch->qty;
                       $batch->qty=0;
                       $batch->update();
                       $product=ProductStockBatch::all();
                       $total=0;
                       foreach ($product as $item){
                           $valuation=$item->qty*$item->purchase_price??0;
                           $total+=$valuation;
                       }
                       $stock_transaction = new StockTransaction();
                       $stock_transaction->product_name = $main_product->product->name;
                       $stock_transaction->stock_out = $stock_out->id;
                       $stock_transaction->warehouse_id = $stock_out->warehouse_id;
                       $stock_transaction->variant_id=$stock_out->variantion_id;
                       $stock_transaction->contact_id=$stock_out->customer_id;
                       $stock_transaction->qty=$qty;
                       $stock_transaction->type ="Stock Out";
                       $stock_transaction->emp_id=$stock_out->emp_id;
                       $stock_transaction->creator_id=$stock_out->creator_id;
                       $stock_transaction->balance=$stock->stock_balance-$qty;
                       $stock_transaction->purchase_price=$batch->purchase_price;
                       $stock_transaction->sale_value=$qty*$batch->purchase_price;
                       $stock_transaction->inventory_value=$total;
                       $stock_transaction->save();
                       if($stock_out->type=='Invoice'){
                           $stock->stock_balance = $stock->stock_balance - $qty;
                       }else{
                           $stock->available=$stock->available - $qty;
                           $stock->stock_balance = $stock->stock_balance - $qty;
                       }

                       $stock->update();
                   }
               }
            }
            return redirect(route('stock.out.index'));
        }else{
            return redirect(route('stock.out.index'))->with('error','Your can not approve.You are not approver');
        }
    }
    public function stock(){
        $stocks=Stock::with('warehouse','variant')->get();
//        dd($stocks);
        $units=SellingUnit::all();
        return view('stock.stock',compact('stocks','units'));
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
                    $new_stock->available=$request->qty;
                    $new_stock->save();

                }else{
                    $product_exist->stock_balance=$product_exist->stock_balance + $request->qty;
                    $product_exist->available=$product_exist->stock_balance + $request->qty;
                    $product_exist->update();
                }

                $out_batch=ProductStockBatch::where('product_id',$request->variantion_id)->where('warehouse_id',$request->current_warehouse_id)->get();
                $remaing=$request->qty;
                foreach ($out_batch as $batch){
                    if($batch->qty!=0){
                        if($batch->qty >= $remaing){
                            $last_batch= ProductStockBatch::orderBy('id', 'desc')->where('product_id',$request['variantion_id'])->first();

                            if ($last_batch != null) {
                                $last_batch->batch_no++;
                                $batch_no = $last_batch->batch_no;
                            } else {
                                $batch_no = "Batch-00001";
                            }
                            $batch->qty=$batch->qty - $remaing;
                            $remaing=0;
                            $batch->update();
                            $data['product_id']=$request->variantion_id;
                            $data['batch_no']=$batch_no;
                            $data['supplier_id']=$batch->supplier_id;
                            $data['qty']=$request->qty;
                            $data['purchase_price']=$batch->purchase_price;
                            $data['exp_date']=$batch->exp_date;
                            $data['warehouse_id']=$request->transfer_warehouse_id;
                            ProductStockBatch::create($data);
                        }else{
                            $last_batch= ProductStockBatch::orderBy('id', 'desc')->where('product_id',$request['variantion_id'])->first();

                            if ($last_batch != null) {
                                $last_batch->batch_no++;
                                $batch_no = $last_batch->batch_no;
                            } else {
                                $batch_no = "Batch-00001";
                            }
                            $remaing=$remaing - $batch->qty;
                            $data['qty']=$batch->qty;
                            $batch->qty=0;
                            $batch->update();
                            $data['product_id']=$request->variantion_id;
                            $data['batch_no']=$batch_no;
                            $data['supplier_id']=$batch->supplier_id;
                            $data['purchase_price']=$batch->purchase_price;
                            $data['exp_date']=$batch->exp_date;
                            $data['warehouse_id']=$request->transfer_warehouse_id;
                            ProductStockBatch::create($data);

                        }
                    }
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
//
            }

            return redirect(route('transfer.index'));
        }
    }
    public function transfer_record(){
        $transfers=StockTransferRecord::with('variant','from','to')->get();
//        dd($transfers);
        return view('stock.transfer_record',compact('transfers'));
    }
    public function export(Request $request)
    {
        if(isset($request->warehouse_id)){
            return Excel::download(new StockExport($request->start_date, $request->end_date,$request->warehouse_id), 'stocks.xlsx');
        }else {
            return Excel::download(new StockExport($request->start_date, $request->end_date,null), 'stocks.xlsx');
        }
    }
    public function damage(){
        $damage=DamagedProduct::with('emp','variant','warehouse')->get();
        return view('stock.damageproduct',compact('damage'));
    }
    public function  update(Request $request,$id){
        $stock=Stock::where('id',$id)->first();
        if($stock->stock_balance<$request->update_stock){
            return redirect('stocks')->with('error','Cannot enter a number greater than the current stock balance');
        }else{
//            dd($request->all());
            $update_hist=new StockUpdatedHistory();
            $update_hist->variant_id=$stock->variant_id;
            $update_hist->stock_id=$id;
            $update_hist->emp_id=Auth::guard('employee')->user()->id;
            $update_hist->before_balance=$request->before_stock;
            $update_hist->updated_balance=$request->update_stock??$request->before_stock;
            $update_hist->before_aval=$stock->available;
            $update_hist->updated_aval=$request->update_stock??$request->before_stock;
            $update_hist->warehouse_id=$stock->warehouse_id;
            $update_hist->save();
            $stock->stock_balance=$request->update_stock??$request->before_stock;
            $stock->available=$request->update_stock??$request->before_stock;
            $stock->alert_qty=$request->alert_qty;
            $stock->update();
            return redirect('stocks')->with('success','Stock Updated Successful');
        }
    }
    public function history($id){
        $units=SellingUnit::all();
        $wareshouse=Warehouse::all()->pluck('name','id')->all();
        $history=StockUpdatedHistory::with('stock','variant')->where('stock_id',$id)->get();
        return view('stock.stockupdatehistory',compact('history','units','wareshouse'));
    }
    public function import(Request $request){
        try {
            Excel::import(new StockImport(), $request->file('import'));
            return redirect()->route('stocks')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            return redirect()->route('stocks')->with('error', $e->getMessage());
        }
    }
    public function batch($id){
        $units=SellingUnit::all();
        $stock_transactions=ProductStockBatch::with('supplier','variant')->where("product_id",$id)->get();
        return view('stock.stockin_batch',compact('stock_transactions','units'));
    }
    public function ecommerce_stock(){
        $units=SellingUnit::all();
        $ecommerce_stocks=EcommerceProduct::with('variant')->get();
        return view('stock.ecommerce_stock',compact('ecommerce_stocks','units'));
    }
//    public function stock_leger(){
//        $data=StockLeger::with('warehouse','unit')->get();
//        return view('stock.leger',compact('data'));
//    }

}
