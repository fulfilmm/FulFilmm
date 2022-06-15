<?php

namespace App\Http\Controllers;


use App\Models\AdvancePayment;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\DamagedProduct;
use App\Models\deal;
use App\Models\DealActivitySchedule;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Freeofchare;
use App\Models\Invoice;
use App\Models\next_plan;
use App\Models\OfficeBranch;
use App\Models\OrderItem;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Region;
use App\Models\Revenue;
use App\Models\SalePipelineRecord;
use App\Models\SaleZone;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockReturn;
use App\Models\StockTransaction;
use App\Models\StockTransferRecord;
use App\Models\Transaction;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function SalePerformance()
    {
        $emp=Employee::all();
        $employee=[];
        foreach ($emp as $saleman){
            if($saleman->role->name=='Sales'){
                array_push($employee,$saleman);
            }
        }
        $performance = [];
        foreach ($employee as $emp) {
            $emp_appointment = next_plan::where('type', 'Meeting')->where('emp_id', $emp->id)->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->count();
            $emp_deal_win = deal::where('sale_stage', 'Win')->where('created_id', $emp->id)->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->count();
            $emp_proposal = Quotation::whereMonth('created_at', date('m'))->where('sale_person_id', $emp->id)
                ->whereYear('created_at', date('Y'))->where('is_confirm', 1)
                ->count();
            $emp_meeting = DealActivitySchedule::where('type', 'Meeting')->where('emp_id', $emp->id)->count();
            $performance[$emp->id]['appointment'] = $emp_appointment;
            $performance[$emp->id]['deal'] = $emp_deal_win;
            $performance[$emp->id]['proposal'] = $emp_proposal;
            $performance[$emp->id]['meeting'] = $emp_meeting;
        }
//            dd($performance);
        $appointment = next_plan::where('type', 'Meeting')->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();
        $deal_win = deal::where('sale_stage', 'Win')->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();
        $proposal = Quotation::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->where('is_confirm', 1)
            ->count();
        $stage = ['New', 'Qualified', 'Quotation', 'Invoicing', 'Win', 'Lost'];
        $salepipeline = [];
        foreach ($stage as $key => $value) {
            $dealeach_stage = deal::where('sale_stage', $value)->count();
            $salepipeline[$value] = $dealeach_stage;
        }
        $meeting = DealActivitySchedule::where('type', 'Meeting')->count();
        $lead = SalePipelineRecord::where('state', 'New')->count();
        $qualified = SalePipelineRecord::where('state', 'Qualified')->count();
        $quotation = SalePipelineRecord::where('state', 'Quotation')->count();
        $win = SalePipelineRecord::where('state', 'Win')->count();
        $lost = SalePipelineRecord::where('state', 'Lost')->count();
        $unqualified = $lead - $qualified;
        $still_qualified = $qualified - $quotation;
        $still_quotation = $quotation - $win - $lost;


//            dd($lead);

        $data = ['appointment' => $appointment, 'deal' => $deal_win, 'proposal' => $proposal, 'meeting' => $meeting, 'lead' => $lead, 'qualified' => $qualified, 'unqualified' => $unqualified, 'quotation' => $quotation, 'win' => $win,
            'still_qualified' => $still_qualified, 'still_quotation' => $still_quotation, 'lost' => $lost];
//        dd($employee);
        return view('Report.saleperformance', compact('data', 'performance', 'employee', 'salepipeline'));

    }//Finish ပီးပီ

    public function stock(Request $request)
    {
        $products = ProductVariations::all();
        $items = [];
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'CEO' || $auth->role->name == 'Super Admin'||$auth->role->name=='Stock Manager') {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                if (isset($request->warehouse_id)) {
                    $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])->where('warehouse_id', $request->warehouse_id)->get();
                } else {
                    $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])->get();
                }
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])->get();
            }

            foreach ($products as $prod) {

                foreach ($stock_transactions as $tran) {
                    if ($tran->variant_id == $prod->id) {
                        $stock = Stock::where('variant_id', $prod->id)->first();
                        if ($tran->type == 'Stock In') {
                            $items[$prod->product_code] = $prod;
                            $items[$prod->product_code]['in'] += $tran->qty;
                            $items[$prod->product_code]['out'] += 0;
                            $items[$prod->product_code]['bal'] = $stock->stock_balance;

                        } elseif ($tran->type == 'Stock Out') {
                            $items[$prod->product_code] = $prod;
                            $items[$prod->product_code]['out'] += $tran->qty;
                            $items[$prod->product_code]['in'] += 0;
                            $items[$prod->product_code]['bal'] = $stock->stock_balance;
                        }
                    }
                }

            }
            $warehouse = Warehouse::all();
            $search_warehouse = $request->warehouse_id;

        } else if ($auth->role->name=='Stock Controller'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                if (isset($request->warehouse_id)) {
                    $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])
                        ->where('warehouse_id', $request->warehouse_id)
                        ->where('branch_id', $auth->office_branch_id)
                        ->get();
                } else {
                    $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])
                        ->where('branch_id', $auth->office_branch_id)
                        ->get();
                }
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')
                    ->where('branch_id', $auth->office_branch_id)
                    ->whereBetween('created_at', [$start, $end])->get();
            }

            foreach ($products as $prod) {

                foreach ($stock_transactions as $tran) {
                    if ($tran->variant_id == $prod->id) {
                        $stock = Stock::where('variant_id', $prod->id)->first();
                        if ($tran->type == 'Stock In') {
                            $items[$prod->product_code] = $prod;
                            $items[$prod->product_code]['in'] += $tran->qty;
                            $items[$prod->product_code]['out'] += 0;
                            $items[$prod->product_code]['bal'] = $stock->stock_balance;

                        } elseif ($tran->type == 'Stock Out') {
                            $items[$prod->product_code] = $prod;
                            $items[$prod->product_code]['out'] += $tran->qty;
                            $items[$prod->product_code]['in'] += 0;
                            $items[$prod->product_code]['bal'] = $stock->stock_balance;
                        }
                    }
                }

            }
            $warehouse = Warehouse::where('branch_id', $auth->office_branch_id)->get();
            $search_warehouse = $request->warehouse_id;

        }else{
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                if (isset($request->warehouse_id)) {
                    $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])
                        ->where('warehouse_id', $request->warehouse_id)
                        ->get();
                } else {
                    $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')->whereBetween('created_at', [$start, $end])
                        ->where('warehouse_id', $auth->warehouse_id)
                        ->get();
                }
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $stock_transactions = StockTransaction::with('stockin', 'stockout', 'variant', 'customer', 'employee', 'stockreturn')
                    ->where('warehouse_id', $auth->warehouse_id)
                    ->whereBetween('created_at', [$start, $end])->get();
            }

            foreach ($products as $prod) {

                foreach ($stock_transactions as $tran) {
                    if ($tran->variant_id == $prod->id) {
                        $stock = Stock::where('variant_id', $prod->id)->first();
                        if ($tran->type == 'Stock In') {
                            $items[$prod->product_code] = $prod;
                            $items[$prod->product_code]['in'] += $tran->qty;
                            $items[$prod->product_code]['out'] += 0;
                            $items[$prod->product_code]['bal'] = $stock->stock_balance;

                        } elseif ($tran->type == 'Stock Out') {
                            $items[$prod->product_code] = $prod;
                            $items[$prod->product_code]['out'] += $tran->qty;
                            $items[$prod->product_code]['in'] += 0;
                            $items[$prod->product_code]['bal'] = $stock->stock_balance;
                        }
                    }
                }

            }
            $warehouse = Warehouse::where('id', $auth->warehouse_id)->get();
            $search_warehouse = $request->warehouse_id;
        }
        return view('Report.stock', compact('items', 'start', 'end', 'warehouse', 'search_warehouse'));
    }//ပီးပီ

    public function income(Request $request)
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('cat', 'employee', 'branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])->get();
            }
        } elseif ($auth->role->name == 'Cashier' || $auth->role->name == 'Accountant'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])->where('branch_id',$auth->office_branch_id)->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])->where('branch_id',$auth->office_branch_id)->get();
            }
        } else {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier','manager', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at', [$start, $end])->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('cat', 'employee', 'branch_cashier','manager', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at', [$start, $end])->get();
            }

        }
        return view('Report.revenue_report', compact('revenues', 'start', 'end'));
    }//ပီးပီ

    public function cash_in_hand(Request $request)
    {

        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])
                    ->where('approve', 1)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee','branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])
                    ->where('approve', 1)
                    ->get();
            }
        }elseif ($auth->role->name == 'Cashier' || $auth->role->name == 'Accountant') {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee','branch_cashier','manager', 'invoice')
                    ->whereBetween('created_at', [$start, $end])
                    ->where('approve', 1)
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with ('cat', 'employee', 'branch_cashier','manager', 'invoice')
                    ->whereBetween('created_at', [$start, $end])
                    ->where('approve', 1)
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            }
        } else {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee','branch_cashier','manager', 'invoice')
                    ->where('emp_id', $auth->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->where('approve', 1)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee','branch_cashier','manager', 'invoice')
                    ->where('emp_id', $auth->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->where('approve', 1)
                    ->get();
            }

        }
        return view('Report.cashinhand', compact('revenues', 'start', 'end'));
    }//ပီးပီ

    public function cash_in_emp(Request $request)
    {

        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier', 'invoice','manager')->whereBetween('created_at', [$start, $end])
                    ->where('approve', 0)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with( 'cat', 'employee', 'branch_cashier','manager', 'invoice')->whereBetween('created_at', [$start, $end])
                    ->where('approve', 0)
                    ->get();
            }
        }elseif ($auth->role->name == 'Cashier' || $auth->role->name == 'Accountant'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('branch_cashier','manager', 'cat', 'employee', 'invoice')->whereBetween('created_at', [$start, $end])
                    ->where('approve', 0)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('branch_cashier','manager', 'cat', 'employee', 'invoice')
                    ->whereBetween('created_at', [$start, $end])
                    ->where('approve', 0)
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            }
        } else {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('manager','branch_cashier', 'cat', 'employee', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at', [$start, $end])
                    ->where('approve', 0)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('branch_cashier','manager', 'cat', 'employee', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at', [$start, $end])
                    ->where('approve', 0)
                    ->get();
            }

        }
        return view('Report.cashinemp', compact('revenues', 'start', 'end'));
    }//ပီးပီ

    public function expense(Request $request)
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO' ){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')->whereBetween('created_at', [$start, $end])->get();
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')->whereDate('transaction_date', Carbon::today())->get();
            }
            $account = Transaction::with('account')->where('type', 'expense')->get();
        }elseif ($auth->role->name == 'Cashier' || $auth->role->name == 'Accountant') {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')
                    ->whereBetween('created_at', [$start, $end])
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')
                    ->whereDate('created_at',[$start,$end])
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            }
            $account = Transaction::with('account')->where('type', 'expense')->get();
        } else {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')->whereBetween('created_at', [$start, $end])
                    ->where('emp_id', $auth->id)
                    ->get();
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')->whereDate('transaction_date', Carbon::today())
                    ->where('emp_id', $auth->id)
                    ->get();
            }
            $account = Transaction::with('account')->where('type', 'expense')->get();

        }
//dd($expenses);
        return view('Report.expense', compact('expenses', 'account', 'start', 'end'));
    }//ပီးပိ

    public function reportpage()
    {
        return view('report');
    }//ပီးပီ

    public function stock_report(Request $request)
    {
        if ($request->ajax()) {
            $stocks = Stock::with('warehouse', 'variant')->get();
            return Datatables::of($stocks)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('unit', function ($data) {
                    if (!isset($data->variant_id)) {
                        $unit = SellingUnit::where('variant_id', $data->variant_id)->where('unit_convert_rate', 1)->first();
                    }
                    return $unit->unit ?? 'N/A';
                })
                ->make(true);
        }
    }//ပီးပီ

    public function stockin(Request $request)
    {
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Stock Manager'){
            $warehouse=Warehouse::all();
            $stockin=StockIn::with('variant','supplier','employee')->whereBetween('created_at',[$start,$end])->get();
        }else if ($auth->role->name=='Stock Controller'){
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockin=StockIn::with('variant','supplier','employee')->whereBetween('created_at',[$start,$end])->where('branch_id',$auth->office_branch_id)->get();
        }else{
            $warehouse=Warehouse::where('id',$auth->wareahouse_id)->get();
            $stockin=StockIn::with('variant','supplier','employee')->whereBetween('created_at',[$start,$end])->where('warehouse_id',$auth->warehouse_id)->get();
        }
        $search_warehouse=$request->warehouse_id;
        return view('Report.stockinreport',compact('stockin','start','end','warehouse','search_warehouse'));
    }

    public function stockout(Request $request)
    {
//        dd($request->all());
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
//        dd($start,$end);
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Stock Manager'){
            $warehouse=Warehouse::all();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->get();
//            dd('hello',$stockout);

        }elseif ($auth->role->name=='Stock Controller'){
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('branch_id',$auth->office_branch_id)
                ->get();
        }else{
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('emp_id',$auth->id)->get();
        }
        $search_warehouse=$request->warehouse_id;
//        dd($stockout);

        return view('Report.stockoutreport',compact('stockout','warehouse','start','end','search_warehouse'));
    }

    public function receivable(Request $request)
    {
        $auth = Auth::guard('employee')->user();
        if ($auth->role->name == 'Super Admin' || $auth->role->name == 'CEO') {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                if (isset($request->branch_id)){
                    $receivable = Invoice::with('customer', 'employee', 'branch', 'region','zone')->whereBetween('created_at', [$start, $end])
                        ->where('branch_id',$request->branch_id)
                        ->where('due_amount','!=', 0)
                        ->get();
                }else{
                    $receivable = Invoice::with('customer', 'employee', 'branch', 'region','zone')->whereBetween('created_at', [$start, $end])
                        ->where('due_amount','!=', 0)
                        ->get();
                }
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                if (isset($request->branch_id)){
                    $receivable =Invoice::with('customer', 'employee', 'branch', 'region','zone')
                        ->whereBetween('created_at', [$start, $end])
                        ->where('branch_id',$request->branch_id)
                        ->where('due_amount','!=', 0)
                        ->get();
                }else{
                    $receivable =Invoice::with('customer', 'employee', 'branch', 'region','zone')
                        ->whereBetween('created_at', [$start, $end])
                        ->where('due_amount','!=', 0)
                        ->get();
                }
            }
            $branch=OfficeBranch::all();
        }elseif ($auth->role->name == 'Cashier' || $auth->role->name == 'Accountant'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $receivable =Invoice::with('customer', 'employee', 'branch', 'region','zone')
                    ->whereBetween('created_at', [$start, $end])
                    ->where('due_amount','!=', 0)
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $receivable=Invoice::with('customer', 'employee', 'branch', 'region','zone')
                    ->whereBetween('created_at', [$start, $end])
                    ->where('due_amount','!=', 0)
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
            }
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        } else {
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $receivable = Invoice::with('customer', 'employee', 'branch', 'region','zone')
                    ->where('emp_id', $auth->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->where('due_amount','!=', 0)
                    ->get();
            } else {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $receivable = Invoice::with('customer', 'employee', 'branch', 'region','zone')
                    ->where('emp_id', $auth->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->where('due_amount','!=', 0)
                    ->get();
            }

            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
        $search_branch=$request->branch_id;
        return view('Report.receivable',compact('branch','receivable','start','end','search_branch'));
    }

    public function bill(Request $request)
    {

        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Finance Manager'){
            $bills=Bill::with('supplier','employee')->whereBetween('created_at',[$start,$end])->get();
            $branch=OfficeBranch::all();
        }elseif ($auth->role->name='Cashier'||$auth->role->name=='Accountant'){
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('branch_id',$auth->office_branch_id)
                ->get();
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $bills=Bill::with('supplier','employee')->whereBetween('created_at',[$start,$end])->where('emp_id',$auth->id)->get();
        }
        $search_branch=$request->branch_id;
        return view('Report.bill',compact('bills','start','end','branch','search_branch'));
    }

    public function payment(Request $request)
    {

        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Finance Manager'){
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('status','!=','Draft')
                ->get();
            $branch=OfficeBranch::all();
        }elseif ($auth->role->name='Cashier'||$auth->role->name=='Accountant'){
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('status','!=','Draft')
                ->where('branch_id',$auth->office_branch_id)
                ->get();
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('status','!=','Draft')
                ->where('emp_id',$auth->id)->get();
        }
        $search_branch=$request->branch_id;
        return view('Report.payment',compact('bills','start','end','branch','search_branch'));
    }

    public function payable(Request $request)
    {
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Finance Manager'){
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('due_amount','!=',0)
                ->get();
            $branch=OfficeBranch::all();
        }elseif ($auth->role->name='Cashier'||$auth->role->name=='Accountant'){
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('due_amount','!=',0)
                ->where('branch_id',$auth->office_branch_id)
                ->get();
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $bills=Bill::with('supplier','employee')
                ->whereBetween('created_at',[$start,$end])
                ->where('due_amount','!=',0)
                ->where('emp_id',$auth->id)->get();
        }
        $search_branch=$request->branch_id;
        return view('Report.payable',compact('bills','start','end','branch','search_branch'));
    }

    public function stockreturn(Request $request)
    {
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Stock Manager'){
            $stock_return=StockReturn::with('invoice','variant','warehouse','employee','creator')
                ->whereBetween('created_at',[$start,$end])
                ->get();
            $branch=OfficeBranch::all();
        }elseif ($auth->role->name='Stock Controller'){
            $stock_return=StockReturn::with('invoice','variant','warehouse','employee','creator')
                ->whereBetween('created_at',[$start,$end])
                ->where('branch_id',$auth->office_branch_id)
                ->get();
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $stock_return=StockReturn::with('invoice','variant','warehouse','employee','creator')
                ->whereBetween('created_at',[$start,$end])
                ->where('creator_id',$auth->id)->get();
        }
        $search_branch=$request->branch_id;
        return view('Report.stockreturn',compact('stock_return','start','end','search_branch','branch'));
    }

    public function stocktransfer(Request $request)
    {
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Stock Manager'){
            $stock_transfer=StockTransferRecord::with('from','to','variant','receiver','branch')
                ->whereBetween('created_at',[$start,$end])
                ->get();
            $branch=OfficeBranch::all();
        }elseif ($auth->role->name='Stock Controller'){
            $stock_transfer=StockTransferRecord::with('from','to','variant','receiver','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('branch_id',$auth->office_branch_id)
                ->get();
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $stock_transfer=StockTransferRecord::with('from','to','variant','receiver','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('receiver_id',$auth->id)->get();
        }
        $search_branch=$request->branch_id;
        return view('Report.stocktransfer',compact('stock_transfer','start','end','search_branch','branch'));
    }

    public function damage(Request $request)
    {
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
//        dd($start,$end);
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $warehouse=Warehouse::all();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->where('type','damage')
                ->whereBetween('created_at',[$start,$end])
                ->get();
//            dd('hello',$stockout);

        }elseif ($auth->role->name=='Stock Controller'){
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('type','damage')
                ->where('branch_id',$auth->office_branch_id)
                ->get();
        }else{
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('type','damage')
                ->where('emp_id',$auth->id)->get();
        }
        $search_warehouse=$request->warehouse_id;
//        dd($stockout);

        return view('Report.damage',compact('stockout','warehouse','start','end','search_warehouse'));
    }

    public function foc(Request $request)
    {
        $auth=Auth::guard('employee')->user();
        if(isset($request->start)){
            $start=Carbon::parse($request->start)->startOfDay();
            $end=Carbon::parse($request->end)->endOfDay();
        }else{
            $start=Carbon::today()->startOfDay();
            $end=Carbon::today()->endOfDay();
        }
//        dd($start,$end);
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $warehouse=Warehouse::all();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('type','foc')
                ->get();
//            dd('hello',$stockout);

        }elseif ($auth->role->name=='Stock Controller'){
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('type','foc')
                ->where('branch_id',$auth->office_branch_id)
                ->get();
        }else{
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $stockout=StockOut::with('variant','emp','warehouse','customer','approver','invoice','branch')
                ->whereBetween('created_at',[$start,$end])
                ->where('type','foc')
                ->where('emp_id',$auth->id)->get();
        }
        $search_warehouse=$request->warehouse_id;
//        dd($stockout);

        return view('Report.foc',compact('stockout','warehouse','start','end','search_warehouse'));
    }

    public function sale_analysis(Request $request)
    {

        $months = ['01'=>'Jan','02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'May', '06'=>'Jun', '07'=>"Jul", '08'=>'Aug', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'];
       $current_year=date('Y');
        $years=[$current_year-2,$current_year-1,$current_year,$current_year+1,$current_year+2];
        if(isset($request->month)){
            $month=$request->month;

        }else{
            $month=date('m');
        }
        if(isset($request->year)){
            $year=$request->year;
        }else{
            $year=$current_year;
        }

//        dd($month);
       $auth=Auth::guard('employee')->user();
       if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
           $emp=Employee::all();
           $branch=OfficeBranch::all();
           $region=Region::with('branch')->get();
           $zone=SaleZone::with('region')->get();

       }elseif ($auth->role->name=='Sales Manager'){
           $emp=Employee::where('office_branch_id',$auth->office_branch_id)->get();
           $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
           $region=Region::with('branch')->where('branch_id',$auth->office_branch_id)->get();
           $zone=[];
           foreach ($region as $reg){
               $zn=SaleZone::with('region')->where('region_id',$reg->id)->get();
               foreach ($zn as $z){
                   array_push($zone,$z);
               }
           }
       }else{
           return redirect()->back()->with('error','You do not have permission to access requested record!');
       }

        $employee=[];
        $branch_sales=[];
        $saleman_sales=[];
        $region_sales=[];
        $zone_sales=[];
        foreach ($emp as $saleman){
            if($saleman->role->name=='Sales'){
                array_push($employee,$saleman);
            }
        }
        foreach ($employee as $emp) {
          if($month=='all'){
              $sales_total = DB::table("invoices")
                  ->select(DB::raw("SUM(grand_total) as total"))
                  ->whereYear('invoice_date',$year)
                  ->where('emp_id',$emp->id)
                  ->where('cancel',0)
                  ->get();
          }else{
              $sales_total = DB::table("invoices")
                  ->select(DB::raw("SUM(grand_total) as total"))
                  ->whereYear('invoice_date',$year)
                  ->whereMonth('invoice_date',$month)
                  ->where('emp_id',$emp->id)
                  ->where('cancel',0)
                  ->get();
          }
            $saleman_sales[$emp->id]['sale']=$sales_total[0]->total??0;
        }
//        dd($month,date('m'));
        foreach ($branch as $data) {
            if($month=='all'){
                $branch_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date',$year)
                    ->where('branch_id',$data->id)
                    ->where('cancel',0)
                    ->get();
            }else{
                $branch_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date',$year)
                    ->where('branch_id',$data->id)
                    ->whereMonth('invoice_date',$month)
                    ->where('cancel',0)
                    ->get();
            }
            $branch_sales[$data->id]['sale']=$branch_total[0]->total??0;
        }
        foreach ($region as $data) {
            if($month=='all'){
                $sales_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date',$year)
                    ->where('region_id',$data->id)
                    ->where('cancel',0)
                    ->get();
            }else{
                $sales_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date',$year)
                    ->where('region_id',$data->id)
                    ->whereMonth('invoice_date',$month)
                    ->where('cancel',0)
                    ->get();
            }
            $region_sales[$data->id]['sale']=$sales_total[0]->total??0;
        }
        foreach ($zone as $data) {
            if($month=='all'){
                $sales_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date',$year)
                    ->where('zone_id',$data->id)
                    ->where('cancel',0)
                    ->get();
            }else{
                $sales_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date',$year)
                    ->where('zone_id',$data->id)
                    ->whereMonth('invoice_date',$month)
                    ->where('cancel',0)
                    ->get();
            }
            $zone_sales[$data->id]['sale']=$sales_total[0]->total??0;
        }

//            dd($branch_sales,$region_sales,$zone_sales,$saleman_sales);


//            dd($lead);

//        dd($employee);
        $search_month=$month;
        $search_year=$year;
        return view('Report.sales_analysis', compact('data', 'employee','branch','region','zone','branch_sales','region_sales','zone_sales','saleman_sales','months','search_month','years','search_year'));

    }//Finish ပီးပီ


}