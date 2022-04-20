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
use App\Models\OfficeBranch;
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

//    public function __construct()
//    {
//        $stock = Stock::with('variant')->get();
//        $employees = Employee::all();
//
//        foreach ($stock as $item) {
//            if ($item->alert_qty >= $item->stock_balance) {
//                foreach ($employees as $emp) {
//                    $exit_noti = Notification::where('type', $item->id)->where('read_at', null)->where('notify_user_id', $emp->id)->first();
//                    if ($emp->role->name == 'Stock Manager' && $exit_noti == null) {
//                        $this->addnotify($emp->id, 'stock not enough', $item->variant->product_name . 'Only ' . $item->stock_balance . ' left in stock', 'stocks', null);
//                    }
//                }
//            }
//        }
//    }
    public function index()
    {
      $auth=Auth::guard('employee')->user();
      if($auth->role->name=='CEO'||$auth->role->name=='Super Admin'){
          $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->get();
          $stocks = Stock::all();
      }else{
          $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->where('branch_id',$auth->office_branch_id)->get();
          $stocks = Stock::where('branch_id',$auth->office_branch_id)->get();
      }
        $units = SellingUnit::all();
//        dd($stock_transactions);
        return view('stock.index', compact('stock_transactions', 'stocks', 'units'));
    }
    public function stockin_form()
    {
        $auth = Auth::guard('employee')->user();
        $products = ProductVariations::with('product')->get();
//        dd($products);
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            $customers = Customer::where('customer_type', 'Supplier')
                ->get();
            $warehouses = Warehouse::all();
            $branch = OfficeBranch::all();
        } else {
            $customers = Customer::where('customer_type', 'Supplier')
                ->where('branch_id', $auth->office_branch_id)
                ->get();
            $warehouses = Warehouse::where('branch_id', $auth->office_branch_id)->get();
            $branch = OfficeBranch::where('id', $auth->office_branch_id)->get();
        }
        $binlook = BinLookUp::all();
        return view('stock.stockin', compact('products', 'customers', 'warehouses', 'binlook', 'branch'));
    }
    public function stockout_form()
    {
        //stock out ကို super admin နဲ့ CEO level လုပ်မရ့ပါ
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='CEO'||$auth->role->name=='Super Admin'){
            return redirect('stockout/index')->with('danger','Super admin and CEO can not do stock out');
        }else{
//            dd('hello');
            $units = SellingUnit::all();
            $batch = ProductStockBatch::all();
            $type = ['Invoice', 'FOC', 'Donation', 'Simple', 'Guest', 'Damage', 'E-commerce Stock'];
            $main_product = product::all();
            $products = ProductVariations::with('product')->get();
//            dd($auth);
            if($auth->office_branch_id!=null){
                $emps = Employee::where('office_branch_id',$auth->office_branch_id)->get();
                $customers = Customer::where('customer_type', 'Lead')->where('status', 'qualified')->where('branch_id',$auth->office_branch_id)->get();
                $couriers = Customer::where('customer_type', 'Courier')->where('branch_id',$auth->office_branch_id)->get();
                $warehouses = Warehouse::where('branch_id',$auth->office_branch_id)->get();
                $invoice = Invoice::where('branch_id',$auth->office_branch_id)->get();
                return view('stock.stockout', compact('emps', 'units', 'products', 'customers', 'warehouses', 'couriers', 'type', 'invoice', 'main_product', 'batch'));

            }else{
                return redirect()->back()->with('danger','You did not have any office branch');
            }
        }

    }
    public function stock_in(Request $request)
    {
        $this->validate($request, [
            'qty' => 'required',
            'warehouse_id' => 'required',
            'supplier_id' => 'required',
            'product_id' => 'required',
            'purchase_price' => 'required',
        ]);
        $data = [
            'qty' => $request->qty,
            'warehouse_id' => $request->warehouse_id,
            'supplier_id' => $request->supplier_id,
            'variantion_id' => $request->product_id,
            'product_location' => $request->product_location,
            'valuation' => $request->purchase_price,
            'exp_date' => $request->exp_date,
            'bin_id' => $request->binlookup_id,
            'alert_month' => Carbon::parse($request->alert_month),
            'branch_id' => $request->branch_id,
        ];
        $this->stockin($data);
        if (isset($request->receive_id)) {
            $product_receive_item = ProductReceiveItem::where('id', $request->receive_id)->first();
            $product_receive_item->is_stocked_in = 1;
            $product_receive_item->update();
        }
        return redirect(route('stocks.index'));
    }
    public function stockout(Request $request)
    {
        $this->validate($request, ['qty' => 'required', 'type' => 'required', 'variantion_id' => 'required']);
        $stock = Stock::where('variant_id', $request->variantion_id)->where('warehouse_id', $request->warehouse_id)->first();
        $warehouse=Warehouse::where('id',$request->warehouse_id)->first();
        $unit = SellingUnit::where('id', $request->sell_unit)->first();
        if($stock!=null){
            if ($stock->stock_balance < ($request->qty * $unit->unit_convert_rate)) {
                return redirect()->back()->with('warning', 'Not Enough Product!Maximum Product is ' . $stock->stock_balance);
            } else {
                $data = [
                    'qty' => ($request->qty * $unit->unit_convert_rate),
                    'customer_id' => $request->customer_id,
                    'emp_id' => $request->emp_id,
                    'variantion_id' => $request->variantion_id,
                    'approver_id' => $request->approver_id,
                    'courier_id' => $request->courier_id,
                    'warehouse_id' => $request->warehouse_id,
                    'description' => $request->description,
                    'invoice_id' => $request->invoice_id,
                    'type' => $request->type,
                    'sell_unit' => $request->sell_unit,
                    'creator_id' => Auth::guard('employee')->user()->id,
                    'branch_id' =>Auth::guard('employee')->user()->office_branch_id,
                ];
                StockOut::create($data);
                $this->addnotify($request->approver_id, 'success', 'Request stock out to you.', 'stockout/index', Auth::guard('employee')->user()->id);
                return redirect(route('stock.out.index'));
            }
        }else{
            return redirect(route('stock.out.index'))->with('error','Does not have this product in '.$warehouse->name);
        }
    }
    public function stockoutindex()
    {
        $stock = StockOut::with('variant', 'warehouse', 'emp', 'approver')->get();
        $units = SellingUnit::all();
        return view('stock.stockoutindex', compact('stock', 'units'));
    }
    public function stockfilter(Request $request)
    {
//        dd($request->all());
        $stocks = Stock::all();
        $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant')->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)])->get();
//        dd($stocks);
        $units = SellingUnit::all();
        return view('stock.index', compact('stock_transactions', 'stocks', 'units'));
    }
    public function approve($id)
    {
        $stock_out = StockOut::with('variant')->where('id', $id)->where('approve', 0)->first();
        if ($stock_out->approver_id == Auth::guard('employee')->user()->id) {
            $stock = Stock::where('variant_id', $stock_out->variantion_id)->where('warehouse_id', $stock_out->warehouse_id)->first();
            $current_bal = $stock->stock_balance;
            $main_product = ProductVariations::with('product')->where('id', $stock_out->variantion_id)->first();
            if ($stock_out->type == 'FOC') {
                $foc = new Freeofchare();
                $foc->variant_id = $stock_out->variantion_id;
                $foc->qty = $stock_out->qty;
                $foc->issuer_id = $stock_out->emp_id;
                $foc->description = $stock_out->description;
                $foc->branch_id = $stock_out->branch_id;
                $foc->save();
            } elseif ($stock_out->type == 'Damage') {
                $data = ['warehouse_id' => $stock_out->warehouse_id, 'emp_id' => $stock_out->emp_id, 'qty' => $stock_out->qty, 'variant_id' => $stock_out->variantion_id, 'branch_id' => $stock_out->branch_id];
                DamagedProduct::create($data);
            } elseif ($stock_out->type == 'E-commerce Stock') {

                $exists_ecommerce_stock = EcommerceProduct::where('product_id', $stock_out->variantion_id)->first();
                if ($exists_ecommerce_stock == null) {
                    $product = product::with('brand', 'category')->where('id', $stock_out->variant->product_id)->first();
                    $ecommerce_stock = new EcommerceProduct();
                    $ecommerce_stock->product_id = $stock_out->variantion_id;
                    $ecommerce_stock->name = $stock_out->variant->product_name;
                    $ecommerce_stock->qty = $stock_out->qty;
                    $ecommerce_stock->brand = $product->brand->name ?? '';
                    $ecommerce_stock->save();
                } else {
                    $exists_ecommerce_stock->qty = $exists_ecommerce_stock->qty + $stock_out->qty;
                    $exists_ecommerce_stock->update();
                }
            }
            $stock_transaction = new StockTransaction();
            $stock_transaction->product_name =$main_product->product->name;
            $stock_transaction->stock_out =$stock_out->id;
            $stock_transaction->warehouse_id =$stock_out->warehouse_id;
            $stock_transaction->variant_id =$stock_out->variantion_id;
            $stock_transaction->contact_id =$stock_out->customer_id;
            $stock_transaction->qty =$stock_out->qty;
            $stock_transaction->type ="Stock Out";
            $stock_transaction->emp_id =$stock_out->emp_id;
            $stock_transaction->creator_id = $stock_out->creator_id;
            $stock_transaction->balance = $stock->stock_balance - $stock_out->qty;
            $stock_transaction->purchase_price = $stock->cos;
            $stock_transaction->sale_value = $stock_out->qty * $stock->cos;
            $stock_transaction->branch_id=$stock_out->branch_id;
            $stock_transaction->save();
            $stock_out->approve = 1;
            $stock_out->update();
            $batches = ProductStockBatch::where('product_id', $stock_out->variantion_id)->where('warehouse_id',$stock_out->warehouse_id)->get();
            $remaing = $stock_out->qty;
            foreach ($batches as $batch) {
                if ($batch->qty != 0) {
                    if ($batch->qty >= $remaing) {
                        $batch->qty = $batch->qty - $remaing;
                        $qty = $remaing;
                        $remaing = 0;
                        $batch->update();
                        if ($stock_out->type == 'Invoice') {
                            $stock->stock_balance = $stock->stock_balance - $qty;
                        } else {
                            $stock->available = $stock->available - $qty;
                            $stock->stock_balance = $stock->stock_balance - $qty;
                        }
                        $stock->update();
                    } else {
                        $qty = $batch->qty;
                        $remaing = $remaing - $batch->qty;
                        $batch->qty = 0;
                        $batch->update();
                        $product = ProductStockBatch::all();
                        if ($stock_out->type == 'Invoice') {
                            $stock->stock_balance = $stock->stock_balance - $qty;
                        } else {
                            $stock->available = $stock->available - $qty;
                            $stock->stock_balance = $stock->stock_balance - $qty;
                        }

                        $stock->update();
                    }
                }
            }

            return redirect(route('stock.out.index'));
        } else {
            return redirect(route('stock.out.index'))->with('error', 'Your can not approve.You are not approver');
        }
    }
    public function stock()
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            $stocks = Stock::with('warehouse', 'variant')->get();
        } else {
            $stocks = Stock::with('warehouse', 'variant')
                ->where('branch_id', $auth->office_branch_id)
                ->get();
        }
//        dd($stocks);
        $units = SellingUnit::all();
        return view('stock.stock', compact('stocks', 'units'));
    }
    public function transfer()
    {
        $warehouse = Warehouse::all();
        $products = ProductVariations::all();
        $employees = Employee::all();
//        dd($products);
        return view('stock.stocktransfer', compact('warehouse', 'products', 'employees'));
    }
    public function stock_transfer(Request $request)
    {
//        dd('hello');
//       dd($request->all());
        $this->validate($request, [
            'qty' => 'required',
            'current_warehouse_id' => 'required',
            'transfer_warehouse_id' => 'required',
            'variantion_id' => 'required',
        ]);
        $auth = Auth::guard('employee')->user();
        $receiver = Employee::where('id', $request->approver_id)->first();
//        dd($branch);
        if ($auth->office_branch_id != null) {
            if ($receiver->office_branch_id != null) {
                if ($request->transfer_warehouse_id == $request->current_warehouse_id) {
                    return redirect()->back()->with('warning', 'Does not need to transfer in same warehouse');
                } else {
                    $stock = Stock::where('variant_id', $request->variantion_id)->where('warehouse_id', $request->current_warehouse_id)->first();
                    if ($stock == null) {
                        return redirect()->back()->with('warning', 'Not Enough Product!Maximum Product is 0');
                    } else {
                        if ($stock->stock_balance < $request->qty) {
                            return redirect()->back()->with('warning', 'Not Enough Product!Maximum Product is ' . $stock->stock_balance);
                        } else {
                            $product_exist = Stock::where('variant_id', $request->variantion_id)->where('warehouse_id', $request->transfer_warehouse_id)->first();
//              dd($product_exist);
//                    dd($request->all());

                            if ($product_exist == null) {
//                   dd($branch);
                                $new_stock = new Stock();
                                $new_stock->product_name = $stock->product_name;
                                $new_stock->variant_id = $request->variantion_id;
                                $new_stock->warehouse_id = $request->transfer_warehouse_id;
                                $new_stock->ontheway_qty = $request->qty;
                                $new_stock->stock_balance = $new_stock->stock_balance ?? 0;
                                $new_stock->available = $new_stock->available ?? 0;
                                $new_stock->cos = $stock->cos;
                                $new_stock->branch_id = $receiver->office_branch_id;
                                $new_stock->save();

                            } else {
                                $product_exist->ontheway_qty += $request->qty;
                                $product_exist->update();
                            }

                            $out_batch = ProductStockBatch::where('product_id', $request->variantion_id)->where('warehouse_id', $request->current_warehouse_id)->get();
                            $remaing = $request->qty;
                            foreach ($out_batch as $batch) {
                                if ($batch->qty != 0) {
                                    if ($batch->qty >= $remaing) {
                                        $batch->qty = $batch->qty - $remaing;
                                        $remaing = 0;
                                        $batch->update();
                                    } else {
                                        $remaing = $remaing - $batch->qty;
                                        $data['qty'] = $batch->qty;
                                        $batch->qty = 0;
                                        $batch->update();

                                    }
                                }
                            }
                            $transfer_record = new StockTransferRecord();
                            $transfer_record->product_name = $stock->product_name;
                            $transfer_record->variant_id = $request->variantion_id;
                            $transfer_record->from_warehouse = $request->current_warehouse_id;
                            $transfer_record->to_warehouse = $request->transfer_warehouse_id;
                            $transfer_record->qty = $request->qty;
                            $transfer_record->receiver_id = $request->approver_id;
                            $transfer_record->validate_qty = $request->qty;
                            $transfer_record->branch_id = $auth->office_branch_id;
                            $transfer_record->emp_id = $auth->id;
                            $transfer_record->save();
                            $stock->stock_balance = $stock->stock_balance - $request->qty;
                            $stock->available = $stock->available - $request->qty;
                            $stock->update();
                            $variant=ProductVariations::with('product')->where('id',$request->variantion_id)->first();
                            $sell_unit=SellingUnit::where('product_id',$variant->product_id)->where('unit_convert_rate',1)->first();
                            $data = [
                                'qty' =>$request->qty,
                                'emp_id' => $auth->id,
                                'variantion_id' => $request->variantion_id,
                                'approver_id' => $auth->id,
                                'warehouse_id' => $request->current_warehouse_id,
                                'description' => $request->description,
                                'type' => 'Warehouse Transfer',
                                'sell_unit' => $sell_unit->id,
                                'creator_id' => Auth::guard('employee')->user()->id,
                                'branch_id' =>Auth::guard('employee')->user()->office_branch_id,
                                'approve'=>1,
                            ];
                            $stock_out=StockOut::create($data);
                            $stock_transaction = new StockTransaction();
                            $stock_transaction->product_name =$variant->product->name;
                            $stock_transaction->stock_out =$stock_out->id;
                            $stock_transaction->warehouse_id =$stock_out->warehouse_id;
                            $stock_transaction->variant_id =$stock_out->variantion_id;
                            $stock_transaction->contact_id =$stock_out->customer_id;
                            $stock_transaction->qty =$stock_out->qty;
                            $stock_transaction->type ="Stock Out";
                            $stock_transaction->emp_id =$stock_out->emp_id;
                            $stock_transaction->creator_id = $stock_out->creator_id;
                            $stock_transaction->balance = $stock->stock_balance - $stock_out->qty;
                            $stock_transaction->purchase_price = $stock->cos;
                            $stock_transaction->sale_value = $stock_out->qty * $stock->cos;
                            $stock_transaction->branch_id=$stock_out->branch_id;
                            $stock_transaction->save();
                            $this->addnotify($request->approver_id, 'noti', 'Request to accept stock transfer', 'transfer/index', Auth::guard('employee')->user()->id);
//
                        }
                    }

                    return redirect(route('transfer.index'));
                }
            } else {
                return redirect()->back()->with('danger', 'Your selected receiver did not have any branch Office!');
            }
        } else {
            return redirect()->back()->with('danger', 'You did not have any branch Office!');
        }
    }
    public function transfer_record()
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin') {
            $transfers = StockTransferRecord::with('variant', 'from', 'to')->get();
        } else {
            $transfers = StockTransferRecord::with('variant', 'from', 'to')->orWhere('emp_id', $auth->id)->orWhere('receiver_id', $auth->id)->get();
        }
//        dd($transfers);
        return view('stock.transfer_record', compact('transfers'));
    }
    public function export(Request $request)
    {
        if (isset($request->warehouse_id)) {
            return Excel::download(new StockExport($request->start_date, $request->end_date, $request->warehouse_id), 'stocks.xlsx');
        } else {
            return Excel::download(new StockExport($request->start_date, $request->end_date, null), 'stocks.xlsx');
        }
    }
    public function damage()
    {
        $damage = DamagedProduct::with('emp', 'variant', 'warehouse')
            ->where('branch_id',Auth::guard('employee')->user()->office_branch_id)
            ->get();
        return view('stock.damageproduct', compact('damage'));
    }
    public function update(Request $request, $id)
    {
        $stock = Stock::where('id', $id)->first();
        if ($stock->stock_balance < $request->update_stock) {
            return redirect('stocks')->with('error', 'Cannot enter a number greater than the current stock balance');
        } else {
//            dd($request->all());
            $update_hist = new StockUpdatedHistory();
            $update_hist->variant_id = $stock->variant_id;
            $update_hist->stock_id = $id;
            $update_hist->emp_id = Auth::guard('employee')->user()->id;
            $update_hist->before_balance = $request->before_stock;
            $update_hist->updated_balance = $request->update_stock ?? $request->before_stock;
            $update_hist->before_aval = $stock->available;
            $update_hist->updated_aval = $request->update_stock ?? $request->before_stock;
            $update_hist->warehouse_id = $stock->warehouse_id;
            $update_hist->save();
            $stock->stock_balance = $request->update_stock ?? $request->before_stock;
            $stock->available = $request->update_stock ?? $request->before_stock;
            $stock->alert_qty = $request->alert_qty;
            $stock->update();
            return redirect('stocks')->with('success', 'Stock Updated Successful');
        }
    }
    public function history($id)
    {
        $units = SellingUnit::all();
        $wareshouse = Warehouse::all()->pluck('name', 'id')->all();
        $history = StockUpdatedHistory::with('stock', 'variant')->where('stock_id', $id)->get();
        return view('stock.stockupdatehistory', compact('history', 'units', 'wareshouse'));
    }
    public function import(Request $request)
    {
        try {
            Excel::import(new StockImport(), $request->file('import'));
            return redirect()->route('stocks')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            return redirect()->route('stocks')->with('error', $e->getMessage());
        }
    }
    public function batch($id)
    {
        $units = SellingUnit::all();
        $stock_transactions = ProductStockBatch::with('supplier', 'variant','warehouse','branch')->where("product_id", $id)->where('branch_id',Auth::guard('employee')->user()->office_branch_id)->get();
        return view('stock.stockin_batch', compact('stock_transactions', 'units'));
    }
    public function ecommerce_stock()
    {
        $units = SellingUnit::all();
        $ecommerce_stocks = EcommerceProduct::with('variant')->get();
        return view('stock.ecommerce_stock', compact('ecommerce_stocks', 'units'));
    }
//    public function stock_leger(){
//        $data=StockLeger::with('warehouse','unit')->get();
//        return view('stock.leger',compact('data'));
//    }
    public function confirm($id)
    {
        $auth = Auth::guard('employee')->user();
        $stock_transfer = StockTransferRecord::where('id', $id)->first();
        if ($auth->office_branch_id != null) {
            if ($stock_transfer->receiver_id == Auth::guard('employee')->user()->id) {
                $product_exist = Stock::where('variant_id', $stock_transfer->variant_id)->where('warehouse_id', $stock_transfer->to_warehouse)->first();
//              dd('here');
//                    $product_exist->stock_balance = $product_exist->stock_balance + $stock_transfer->validate_qty;
//                    $product_exist->available = $product_exist->available + $stock_transfer->validate_qty;
                $product_exist->ontheway_qty -= $stock_transfer->validate_qty;
                $product_exist->update();


                $out_batch = ProductStockBatch::where('product_id', $stock_transfer->variant_id)->where('warehouse_id', $stock_transfer->from_warehouse)->get();
//              dd($out_batch);
                $remaing = $stock_transfer->validate_qty;
                foreach ($out_batch as $batch) {
                    if ($batch->qty != 0) {
                        if ($batch->qty >= $remaing) {
                            $stockdata = [
                                'qty' => $stock_transfer->validate_qty,
                                'warehouse_id' => $stock_transfer->to_warehouse,
                                'supplier_id' => $batch->supplier_id,
                                'variantion_id' => $stock_transfer->variant_id,
                                'valuation' => $batch->purchase_price,
                                'exp_date' => $batch->exp_date,
                                'branch_id' => $auth->office_branch_id,
                            ];
                            $this->stockin($stockdata);
                            break;
                        }
                        else {
                            $stockdata = [
                                'qty' => $stock_transfer->validate_qty,
                                'warehouse_id' => $stock_transfer->to_warehouse,
                                'supplier_id' => $batch->supplier_id,
                                'variantion_id' => $stock_transfer->variant_id,
                                'valuation' => $batch->purchase_price,
                                'exp_date' => $batch->exp_date,
                                'branch_id' => $auth->office_branch_id,
                            ];
                            $this->stockin($stockdata);

                        }
                    }
                }
                $stock_transfer->receipt = 1;
                $stock_transfer->update();
                return redirect()->back()->with('success', 'Stock Transfer Receipted');
            } else {
                return redirect()->back()->with('error', 'You are not receiver');
            }
        } else {
            return redirect()->back()->with('error', 'You did not not connect any office branch');
        }
    }
    public function transfer_validate(Request $request, $id)
    {
        $transfer = StockTransferRecord::where('id', $id)->first();
        $transfer->validate_qty = $request->validate_qty;
        $transfer->validated = 1;
        $transfer->update();
        return redirect('transfer/index')->with('success', 'Stock transfer qty validated');
    }
    public function expired_product()
    {
        $stock_transactions = ProductStockBatch::with('supplier', 'variant')->where('exp_date', '<', Carbon::today())->get();
        $units = SellingUnit::all();
        $type = 'Expired Product';
        return view('stock.stockin_batch', compact('stock_transactions', 'units', 'type'));
    }
    public function alert_product()
    {
        $stock_transactions = ProductStockBatch::with('supplier', 'variant')->where('alert_month', '<', Carbon::today())->get();
        $units = SellingUnit::all();
        $type = 'Expired Alert Product';
        return view('stock.stockin_batch', compact('stock_transactions', 'units', 'type'));
    }

}
