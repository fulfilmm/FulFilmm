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
use App\Models\Quotation;
use App\Models\Revenue;
use App\Models\SalePipelineRecord;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    }

    public function stockin(Request $request)
    {
        if ($request->ajax()) {
            $stock_in = StockTransaction::with('stockin', 'stockout', 'variant', 'warehouse')->where('type', 1)->whereDate('created_at', Carbon::today())->get();

            return Datatables::of($stock_in)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('supplier', function ($row) {
                    $suppliers = Customer::where('id', $row->stockin->supplier_id)->first();
                    return $suppliers->name??'';
                })
                ->addColumn('unit',function ($data){
                   if(!isset($data->stockin->variantion_id)){
                       $unit=SellingUnit::where('variant_id',$data->stockin->variantion_id)->where('unit_convert_rate',1)->first();
                   }
                    return $unit->unit??'';
                })
                ->make(true);

        }
    }

    public function stockout(Request $request)
    {
        if ($request->ajax()) {
            $stock_out = StockTransaction::with('stockin', 'stockout', 'variant', 'warehouse')->where('type', 0)->whereDate('created_at', Carbon::today())->get();
            return Datatables::of($stock_out)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('unit',function ($variant){
                    $unit=SellingUnit::where('id',$variant->stockout->sell_unit)->first();
                    return $unit->unit??'';
                })
                ->addColumn('qty', function ($row) {
                    $unit=SellingUnit::where('id',$row->stockout->sell_unit)->first();
                    $qty=$row->stockout->qty/$unit->unit_convert_rate;
                    return $qty??0;
                })
                ->addColumn('customer', function ($row) {
                    $suppliers = Customer::where('id', $row->stockout-> customer_id)->first();
                    return $suppliers->name??'';
                })
                ->make(true);
        }
    }

    public function stockreportSearch(Request $request)
    {
        $stock_out = StockOut::with('variant')->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)])->get();
        $stock_in = StockIn::with('variant')->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)])->get();
    }

    public function totalsale()
    {

    }
    public function todayincome(Request $request){
        if ($request->ajax()) {
            $income = Revenue::with('invoice','customer','employee','approver')->whereDate('transaction_date',Carbon::today())->get();
            return Datatables::of($income)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('account',function ($data){
                    $account=Transaction::with('account')->where('revenue_id',$data->id)->first();
                    return $account->account->name??'N/A';
                })
                ->addColumn('transaction',function ($data){
                    if($data->approve==0){
                        return 'No';
                    }else{
                        return 'Yes';
                    }
                })
                ->make(true);
        }
    }

    public function reportpage()
    {
        $total_sale = DB::table("invoices")
            ->select(DB::raw("SUM(total) as total"))
            ->whereDate('created_at',Carbon::today())
            ->get();
        $items=OrderItem::with('variant','unit','invoice')->where('inv_id','!=',null)->whereDate('created_at',Carbon::today())->get();
        return view('Report.report',compact('items','total_sale'));
    }
    public function expense_report(Request $request){
        if ($request->ajax()) {
            $expense = Expense::with( 'supplier', 'employee', 'approver')->whereDate('transaction_date', Carbon::today())->get();
            return Datatables::of($expense)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString();
                    return $formatedDate;
                })
                ->addColumn('account',function ($data){
                    $account=Transaction::with('account')->where('expense_id',$data->id)->first();
                    return $account->account->name??'N/A';
                })
                ->addColumn('supplier',function ($data){
                    return $data->supplier->name??'N/A';
                })
                ->addColumn('transaction',function ($data){
                    if($data->approve==0){
                        return 'No';
                    }else{
                        return 'Yes';
                    }
                })
                ->make(true);
                }
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
                    if(!isset($data->stockin->variantion_id)) {
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