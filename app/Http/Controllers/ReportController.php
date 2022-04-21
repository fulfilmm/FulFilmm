<?php

namespace App\Http\Controllers;


use App\Models\AdvancePayment;
use App\Models\Customer;
use App\Models\deal;
use App\Models\DealActivitySchedule;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\next_plan;
use App\Models\OrderItem;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Revenue;
use App\Models\SalePipelineRecord;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockTransaction;
use App\Models\Transaction;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function SalePerformance()
    {

        $dept = Department::where('name', 'Sale Department')->first();
        $employee = Employee::where('department_id', $dept->id)->get();
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
        $products=ProductVariations::all();
        $items=[];
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='CEO'||$auth->role->name=='Super Admin'){
            if(isset($request->start)){
                $start=Carbon::parse($request->start)->startOfDay();
                $end=Carbon::parse($request->end)->endOfDay();
                if(isset($request->warehouse_id)){
                    $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')->whereBetween('created_at',[$start,$end])->where('warehouse_id',$request->warehouse_id)->get();
                }else{
                    $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')->whereBetween('created_at',[$start,$end])->get();
                }
            }else{
                $start=Carbon::today()->startOfDay();
                $end=Carbon::today()->endOfDay();
                $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')->whereBetween('created_at',[$start,$end])->get();
            }

            foreach ($products as $prod){

                foreach ($stock_transactions as $tran){
                    if($tran->variant_id==$prod->id){
                        $stock=Stock::where('variant_id',$prod->id)->first();
                        if($tran->type=='Stock In'){
                            $items[$prod->product_code]=$prod;
                            $items[$prod->product_code]['in']+=$tran->qty;
                            $items[$prod->product_code]['out']+=0;
                            $items[$prod->product_code]['bal']=$stock->stock_balance;

                        }elseif ($tran->type=='Stock Out'){
                            $items[$prod->product_code]=$prod;
                            $items[$prod->product_code]['out']+=$tran->qty;
                            $items[$prod->product_code]['in']+=0;
                            $items[$prod->product_code]['bal']=$stock->stock_balance;
                        }
                    }
                }

            }
            $warehouse=Warehouse::all();
            $search_warehouse=$request->warehouse_id;
        }else{
            if(isset($request->start)){
                $start=Carbon::parse($request->start)->startOfDay();
                $end=Carbon::parse($request->end)->endOfDay();
                if(isset($request->warehouse_id)){
                    $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')->whereBetween('created_at',[$start,$end])
                        ->where('warehouse_id',$request->warehouse_id)
                        ->where('branch_id',$auth->office_branch_id)
                        ->get();
                }else{
                    $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')->whereBetween('created_at',[$start,$end])
                        ->where('branch_id',$auth->office_branch_id)
                        ->get();
                }
            }else{
                $start=Carbon::today()->startOfDay();
                $end=Carbon::today()->endOfDay();
                $stock_transactions = StockTransaction::with('stockin', 'stockout','variant','customer','employee','stockreturn')
                   ->where('branch_id',$auth->office_branch_id)
                    ->whereBetween('created_at',[$start,$end])->get();
            }

            foreach ($products as $prod){

                foreach ($stock_transactions as $tran){
                    if($tran->variant_id==$prod->id){
                        $stock=Stock::where('variant_id',$prod->id)->first();
                        if($tran->type=='Stock In'){
                            $items[$prod->product_code]=$prod;
                            $items[$prod->product_code]['in']+=$tran->qty;
                            $items[$prod->product_code]['out']+=0;
                            $items[$prod->product_code]['bal']=$stock->stock_balance;

                        }elseif ($tran->type=='Stock Out'){
                            $items[$prod->product_code]=$prod;
                            $items[$prod->product_code]['out']+=$tran->qty;
                            $items[$prod->product_code]['in']+=0;
                            $items[$prod->product_code]['bal']=$stock->stock_balance;
                        }
                    }
                }

            }
            $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
            $search_warehouse=$request->warehouse_id;

        }
        return view('Report.stock',compact('items','start','end','warehouse','search_warehouse'));
    }

    public function income(Request $request){
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Cashier'||$auth->role->name=='Accountant'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                 $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->whereBetween('created_at',[$start,$end])->get();
                }else{
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->whereBetween('created_at',[$start,$end])->get();
            }
        }else{
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at',[$start,$end])->get();
            }else{
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at',[$start,$end])->get();
            }

        }
        return view('Report.revenue_report',compact('revenues','start','end'));
    }
    public function cash_in_hand(Request $request){

        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Cashier'||$auth->role->name=='Accountant'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->whereBetween('created_at',[$start,$end])
                    ->where('approve',1)
                    ->get();
            }else{
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->whereBetween('created_at',[$start,$end])
                    ->where('approve',1)
                    ->get();
            }
        }else{
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at',[$start,$end])
                    ->where('approve',1)
                    ->get();
            }else{
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at',[$start,$end])
                    ->where('approve',1)
                    ->get();
            }

        }
        return view('Report.cashinhand',compact('revenues','start','end'));
    }
    public function cash_in_emp(Request $request){

        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Cashier'||$auth->role->name=='Accountant'){
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->whereBetween('created_at',[$start,$end])
                    ->where('approve',0)
                    ->get();
            }else{
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->whereBetween('created_at',[$start,$end])
                    ->where('approve',0)
                    ->get();
            }
        }else{
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at',[$start,$end])
                    ->where('approve',0)
                    ->get();
            }else{
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $revenues = Revenue::with('account', 'cat', 'employee', 'approver', 'invoice')->where('emp_id', $auth->id)->whereBetween('created_at',[$start,$end])
                    ->where('approve',0)
                    ->get();
            }

        }
        return view('Report.cashinhand',compact('revenues','start','end'));
    }
    public function expense(Request $request){
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Cashier'||$auth->role->name=='Accountant') {
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
        }else{
            if (isset($request->start)) {
                $start = Carbon::parse($request->start)->startOfDay();
                $end = Carbon::parse($request->end)->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')->whereBetween('created_at', [$start, $end])
                    ->where('emp_id',$auth->id)
                    ->get();
            } else {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $expenses = Expense::with('supplier', 'employee', 'approver')->whereDate('transaction_date', Carbon::today())
                    ->where('emp_id',$auth->id)
                    ->get();
            }
            $account = Transaction::with('account')->where('type', 'expense')->get();

        }
//dd($expenses);
        return view('Report.expense',compact('expenses','account','start','end'));
    }
    public function credit_purchase(Request $request){
        $purchase=PurchaseOrder::where('paid_bill',0)->get();
        foreach ($purchase as $item){
//            $item
        }

    }
    public function payment_purchase(Request $request){

    }
    public function reportpage()
    {
        return view('report');
    }

    public function stock_report(Request $request){
        if ($request->ajax()) {
            $stocks=Stock::with('warehouse','variant')->get();
            return Datatables::of($stocks)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('unit',function ($data){
                    if(!isset($data->variant_id)) {
                        $unit = SellingUnit::where('variant_id', $data->variant_id)->where('unit_convert_rate', 1)->first();
                    }
                    return $unit->unit??'N/A';
                })
                ->make(true);
        }
    }
    public function advancedaily(Request $request){
        if ($request->ajax()) {
            $advancepayment=AdvancePayment::with('customer','emp','order','account')->get();
        }
            return Datatables::of($advancepayment)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('account',function ($data){
                    return $data->account->name??'N/A';
                })
                ->make(true);
        }


}