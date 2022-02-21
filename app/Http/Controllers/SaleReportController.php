<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SaleReportController extends Controller
{
    public function sale_report(Request $request){
        if ($request->ajax()) {
            $sale_item=OrderItem::with('invoice','variant')->where('state',1)->whereDate('created_at',Carbon::today())->get();
            return Datatables::of($sale_item)
                ->addIndexColumn()
                ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString(); return $formatedDate; })
                ->addColumn('action', function($row){

                    $cust =Customer::where('id',$row->invoice->customer_id)->first();

                    return $cust->name;
                })
                ->make(true);
        }
        $total_sale = DB::table("invoices")
            ->select(DB::raw("SUM(grand_total) as total"))
            ->whereDate('created_at',Carbon::today())
            ->get();
        $debt_amount = DB::table("invoices")
            ->select(DB::raw("SUM(due_amount) as total"))
            ->whereDate('created_at',Carbon::today())
            ->get();
        $income = DB::table("revenues")
            ->select(DB::raw("SUM(amount) as total"))
            ->whereDate('created_at',Carbon::today())
            ->get();
        $total_reatail_sale = DB::table("invoices")
            ->select(DB::raw("SUM(grand_total) as total"))
            ->where('inv_type','Retail')
            ->whereDate('created_at',Carbon::today())
            ->get();

       return view('sale.salereport',compact('total_sale','income','debt_amount','total_reatail_sale'));
    }
}
