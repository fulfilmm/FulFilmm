<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\OfficeBranch;
use App\Models\OrderItem;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;
use Yajra\DataTables\DataTables;

class SaleReportController extends Controller
{
    public function sale_report(Request $request){

       if($request->start){
           $start=Carbon::parse($request->start)->startOfDay();
           $end=Carbon::parse($request->end)->endOfDay();
           if(isset($request->branch_id)){
               $inv=Invoice::where('branch_id',$request->branch_id)->whereBetween('created_at',[$start,$end])->get();
               $items=[];
               foreach ($inv as $item){
                   $orderitem=OrderItem::with('variant','unit','invoice')->where('inv_id',$item->id)->first();
                   if($item!=null){
                       array_push($items,$orderitem);
                   }
               }

               $total_sale = DB::table("invoices")
                   ->select(DB::raw("SUM(total) as total"))
                   ->whereBetween('created_at',[$start,$end])
                   ->where('branch_id',$request->branch_id)
                   ->get();
               $total_sale_amount= DB::table("invoices")
                   ->select(DB::raw("SUM(grand_total) as total"))
                   ->whereBetween('created_at',[$start,$end])
                   ->where('branch_id',$request->branch_id)
                   ->where('inv_type','Whole Sale')
                   ->get();
               $debt_amount = DB::table("invoices")
                   ->select(DB::raw("SUM(due_amount) as total"))
                   ->whereBetween('created_at',[$start,$end])
                   ->where('branch_id',$request->branch_id)
                   ->get();
               $total_reatail_sale = DB::table("invoices")
                   ->select(DB::raw("SUM(grand_total) as total"))
                   ->where('inv_type','Retail Sale')
                   ->where('branch_id',$request->branch_id)
                   ->whereBetween('created_at',[$start,$end])
                   ->get();
           }else{
               $items=OrderItem::with('variant','unit','invoice')->where('inv_id','!=',null)->whereBetween('created_at',[$start,$end])->get();
               $total_sale = DB::table("invoices")
                   ->select(DB::raw("SUM(total) as total"))
                   ->whereBetween('created_at',[$start,$end])
                   ->get();
               $total_sale_amount= DB::table("invoices")
                   ->select(DB::raw("SUM(grand_total) as total"))
                   ->whereBetween('created_at',[$start,$end])
                   ->where('inv_type','Whole Sale')
                   ->get();
               $debt_amount = DB::table("invoices")
                   ->select(DB::raw("SUM(due_amount) as total"))
                   ->whereBetween('created_at',[$start,$end])
                   ->get();
               $total_reatail_sale = DB::table("invoices")
                   ->select(DB::raw("SUM(grand_total) as total"))
                   ->where('inv_type','Retail Sale')
                   ->whereBetween('created_at',[$start,$end])
                   ->get();
           }
       }else{
           $start=Carbon::today()->startOfDay();
           $end=Carbon::today()->endOfDay();
           $total_sale = DB::table("invoices")
               ->select(DB::raw("SUM(total) as total"))
               ->whereBetween('created_at',[$start,$end])
               ->get();
           $items=OrderItem::with('variant','unit','invoice')->where('inv_id','!=',null)->whereDate('created_at',Carbon::today())->get();
           $total_sale_amount= DB::table("invoices")
               ->select(DB::raw("SUM(grand_total) as total"))
               ->whereDate('created_at',Carbon::today())
               ->where('inv_type','Whole Sale')
               ->get();
           $debt_amount = DB::table("invoices")
               ->select(DB::raw("SUM(due_amount) as total"))
               ->whereDate('created_at',Carbon::today())
               ->get();
           $total_reatail_sale = DB::table("invoices")
               ->select(DB::raw("SUM(grand_total) as total"))
               ->where('inv_type','Retail Sale')
               ->whereDate('created_at',Carbon::today())
               ->get();
       }
        $data=[];
        $i=0;
        foreach ($items as $item){
            if(isset($data[$item->variant->product_code."_".$i])){
                if($data[$item->variant->product_code."_".$i]->unit_price==$item->unit_price) {
                    $data[$item->variant->product_code."_".$i]->quantity += $item->quantity;
                    $data[$item->variant->product_code."_".$i]->total += $item->total;
                }else{
                    $i ++;
                    $data[$item->variant->product_code.'_'.$i]=$item;
                }
            }else{
                $data[$item->variant->product_code."_".$i]=$item;
            }
        }
//        dd($items);
        $branch=OfficeBranch::all()->pluck('name','id')->all();
        $search_branch=$request->branch_id;

       return view('Report.salereport',compact('total_sale_amount','debt_amount','total_reatail_sale','branch','total_sale','data','start','end','search_branch'));
    }
}
