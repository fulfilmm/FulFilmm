<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Invoice;
use App\Models\OfficeBranch;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($request->all());
        if($request->start!=null||$request->end!=null){
            $start=Carbon::parse($request->start);
            $end=Carbon::parse($request->end);
        }else{
            $start=Carbon::today();
            $end=Carbon::today();
        }

        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Stock Manager'){
            $branches=OfficeBranch::all();
            $employees=Employee::all();
            if($request->branch_id==null) { //branch null
               if($request->emp_id==null){ //branch null and emp_id null
                   $origin_stock=[];
                       $items=Stock::with('warehouse','variant','unit')->get();
                       $balance=DB::table("stocks")
                           ->select(DB::raw("SUM(stock_balance) as total"))
                           ->get();
                   $total_balance=$balance[0]->total;

                       foreach ($items as $item){
                           array_push($origin_stock,$item);
                       }
                   $invoice = Invoice::with('customer', 'employee', 'branch')->whereBetween('invoice_date', [$start, $end])->get();

                   $total_sale_amount = DB::table("invoices")
                       ->select(DB::raw("SUM(grand_total) as total"))
                       ->whereBetween('invoice_date', [$start, $end])->get();
                   $debt_amount = DB::table("invoices")
                       ->select(DB::raw("SUM(due_amount) as total"))
                       ->whereBetween('invoice_date', [$start, $end])->get();
                   $inhand_amount = DB::table("employees")
                       ->select(DB::raw("SUM(amount_in_hand) as total"))->get();
                   $cash_in_transit=$inhand_amount[0]->total;
                   //emp null and branch null
               }else{
                    //branch null emp exists
                   $emp=Employee::where('id',$request->emp_id)->first();
                   $origin_stock=[];
                   $items=Stock::with('warehouse','variant','unit')->where('warehouse_id',$emp->warehouse_id)->get();
                   $balance=DB::table("stocks")
                       ->select(DB::raw("SUM(stock_balance) as total"))
                       ->where('warehouse_id',$emp->warehouse_id)
                       ->get();
                   $total_balance=$balance[0]->total;
                   foreach ($items as $item){
                       array_push($origin_stock,$item);
                   }
                   $invoice = Invoice::with('customer', 'employee', 'branch')->whereBetween('invoice_date', [$start, $end])->where('emp_id',$request->emp_id)->get();
                   $total_sale_amount = DB::table("invoices")
                       ->select(DB::raw("SUM(grand_total) as total"))
                       ->where('emp_id',$request->emp_id)
                       ->whereBetween('invoice_date', [$start, $end])->get();
                   $debt_amount = DB::table("invoices")
                       ->select(DB::raw("SUM(due_amount) as total"))
                       ->where('emp_id',$request->emp_id)
                       ->whereBetween('invoice_date', [$start, $end])->get();
                   $search_emp=Employee::where('id',$request->emp_id)->first();
                   $cash_in_transit=$search_emp->amount_in_hand;
               }
               //branch null
            }else {
                    //branch exists,emp null
                if($request->emp_id==null){

                    $origin_stock=[];
                    $total_balance=0;
                    $warehouse=Warehouse::where('branch_id',$request->branch_id)->get();
                    foreach ($warehouse as $wh){
                        $items=Stock::with('warehouse','variant','unit')->where('warehouse_id',$wh->id)->get();
                        $each_balance=DB::table("stocks")
                            ->select(DB::raw("SUM(stock_balance) as total"))
                            ->where('warehouse_id',$wh->id)
                            ->get();
                        $total_balance+=$each_balance[0]->total;
                        foreach ($items as $item){
                            array_push($origin_stock,$item);
                        }
                    }

                    $invoice = Invoice::with('customer', 'employee', 'branch')->whereBetween('invoice_date', [$start, $end])->where('branch_id',$request->branch_id)->get();
                    $total_sale_amount = DB::table("invoices")
                        ->select(DB::raw("SUM(grand_total) as total"))
                        ->where('branch_id',$request->branch_id)
                        ->whereBetween('invoice_date', [$start, $end])->get();
                    $debt_amount = DB::table("invoices")
                        ->select(DB::raw("SUM(due_amount) as total"))
                        ->where('branch_id',$request->branch_id)
                        ->whereBetween('invoice_date', [$start, $end])->get();
                    $inhand_amount = DB::table("employees")
                        ->select(DB::raw("SUM(amount_in_hand) as total"))
                        ->where('office_branch_id',$request->branch_id)
                        ->get();
                    $cash_in_transit=$inhand_amount[0]->total;
                }else{
                     //branch exists,emp exits
                    $emp=Employee::where('id',$request->emp_id)->first();
                    $origin_stock=[];
                    $items=Stock::with('warehouse','variant','unit')->where('warehouse_id',$emp->warehouse_id)->get();
                    $each_balance=DB::table("stocks")
                        ->select(DB::raw("SUM(stock_balance) as total"))
                        ->where('warehouse_id',$emp->warehouse_id)
                        ->get();
                    $total_balance=$each_balance[0]->total;
                    foreach ($items as $item){
                        array_push($origin_stock,$item);
                    }
                    $invoice = Invoice::with('customer', 'employee', 'branch')->whereBetween('invoice_date', [$start, $end])->where('emp_id',$request->emp_id)->get();
                    $total_sale_amount = DB::table("invoices")
                        ->select(DB::raw("SUM(grand_total) as total"))
                        ->where('emp_id',$request->emp_id)
                        ->whereBetween('invoice_date', [$start, $end])->get();
                    $debt_amount = DB::table("invoices")
                        ->select(DB::raw("SUM(due_amount) as total"))
                        ->where('emp_id',$request->emp_id)
                        ->whereBetween('invoice_date', [$start, $end])->get();
                    $search_emp=Employee::where('id',$request->emp_id)->first();
                    $cash_in_transit=$search_emp->amount_in_hand;
                }
            }
             $total_sold=0;
                foreach ($invoice as $inv) {
                    $orderitem = OrderItem::with('variant', 'unit', 'invoice')->where('inv_id', $inv->id)->get();
                    if($orderitem!=null){

                           foreach ($origin_stock as $st){
                              foreach ($orderitem as $oritem){
                                  if($st->warehouse_id==$item->warehouse_id && $oritem->variant_id==$st['variant_id']){
                                      $st->sold_qty+=($oritem->quantity*$oritem->unit->unit_convert_rate);
                                      $total_sold+=($oritem->quantity*$oritem->unit->unit_convert_rate);

                                  }else{
                                      $st->sold_qty=0;
                                  }
                              }
                           }
                       }

                }



        }
        else if ($auth->role->name=='Finance Manager'||$auth->role->name=='Stock Controller'){
            $branches=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $employees=Employee::where('office_branch_id',$auth->office_branch_id)->get();
            if($request->emp_id==null){
                $origin_stock=[];
                $total_balance=0;
                $warehouse=Warehouse::where('branch_id',$auth->office_branch_id)->get();
                foreach ($warehouse as $wh){
                    $items=Stock::with('warehouse','variant','unit')->where('warehouse_id',$wh->id)->get();
                    $each_balance=DB::table("stocks")
                        ->select(DB::raw("SUM(stock_balance) as total"))
                        ->where('warehouse_id',$wh->id)
                        ->get();
                    $total_balance+=$each_balance[0]->total;
                    foreach ($items as $item){
                        array_push($origin_stock,$item);
                    }
                }
                $invoice = Invoice::with('customer', 'employee', 'branch')
                    ->whereBetween('invoice_date', [$start, $end])
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
                $total_sale_amount = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('invoice_date', [$start, $end])
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
                $debt_amount = DB::table("invoices")
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->whereBetween('invoice_date', [$start, $end])
                    ->where('branch_id',$auth->office_branch_id)
                    ->get();
                $inhand_amount = DB::table("employees")
                    ->select(DB::raw("SUM(amount_in_hand) as total"))
                    ->where('office_branch_id',$auth->office_branch_id)
                    ->get();
                $cash_in_transit=$inhand_amount[0]->total;
            }else{
                $emp=Employee::where('id',$request->emp_id)->first();
                $origin_stock=[];
                $items=Stock::with('warehouse','variant','unit')->where('warehouse_id',$emp->warehouse_id)->get();
                $each_balance=DB::table("stocks")
                    ->select(DB::raw("SUM(stock_balance) as total"))
                    ->where('warehouse_id',$emp->warehouse_id)
                    ->get();
                $total_balance=$each_balance[0]->total;
                foreach ($items as $item){
                    array_push($origin_stock,$item);
                }
                $invoice = Invoice::with('customer', 'employee', 'branch')->whereBetween('invoice_date', [$start, $end])->where('emp_id',$request->emp_id)->get();
                $total_sale_amount = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->where('emp_id',$request->emp_id)
                    ->whereBetween('invoice_date', [$start, $end])->get();
                $debt_amount = DB::table("invoices")
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->where('emp_id',$request->emp_id)
                    ->whereBetween('invoice_date', [$start, $end])->get();
                $search_emp=Employee::where('id',$request->emp_id)->first();
                $cash_in_transit=$search_emp->amount_in_hand;
            }
            $total_sold=0;
            foreach ($invoice as $inv) {
                $orderitem = OrderItem::with('variant', 'unit', 'invoice')->where('inv_id', $inv->id)->get();
                if($orderitem!=null){

                    foreach ($origin_stock as $st){
                        foreach ($orderitem as $oritem){
                            if($st->warehouse_id==$item->warehouse_id && $oritem->variant_id==$st['variant_id']){
                                $st->sold_qty+=($oritem->quantity*$oritem->unit->unit_convert_rate);
                                $total_sold+=($oritem->quantity*$oritem->unit->unit_convert_rate);

                            }else{
                                $st->sold_qty=0;
                            }
                        }
                    }
                }

            }
        }else{
            $branches=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $employees=Employee::where('id',$auth->id)->get();
            $origin_stock=[];
            $items=Stock::with('warehouse','variant','unit')->where('warehouse_id',Auth::guard('employee')->user()->warehouse_id)->get();
            $each_balance=DB::table("stocks")
                ->select(DB::raw("SUM(stock_balance) as total"))
                ->where('warehouse_id',$auth->warehouse_id)
                ->get();
            $total_balance=$each_balance[0]->total;
            foreach ($items as $item){
                array_push($origin_stock,$item);
            }
            $invoice = Invoice::with('customer', 'employee', 'branch')->whereBetween('invoice_date', [$start, $end])->where('emp_id',$request->emp_id)->get();
            $total_sale_amount = DB::table("invoices")
                ->select(DB::raw("SUM(grand_total) as total"))
                ->where('emp_id',$request->emp_id)
                ->whereBetween('invoice_date', [$start, $end])->get();
            $debt_amount = DB::table("invoices")
                ->select(DB::raw("SUM(due_amount) as total"))
                ->where('emp_id',$request->emp_id)
                ->whereBetween('invoice_date', [$start, $end])->get();
            $cash_in_transit=$auth->amount_in_hand;
            $total_sold=0;
            foreach ($invoice as $inv) {
                $orderitem = OrderItem::with('variant', 'unit', 'invoice')->where('inv_id', $inv->id)->get();
                if($orderitem!=null){

                    foreach ($origin_stock as $st){
                        foreach ($orderitem as $oritem){
                            if($st->warehouse_id==$item->warehouse_id && $oritem->variant_id==$st['variant_id']){
                                $st->sold_qty+=($oritem->quantity*$oritem->unit->unit_convert_rate);
                                $total_sold+=($oritem->quantity*$oritem->unit->unit_convert_rate);

                            }else{
                                $st->sold_qty=0;
                            }
                        }
                    }
                }

            }
        }








        if($request->emp_id!=null){
            $emp_id=$request->emp_id;
        }else{
         $emp_id='';

        }
        if($request->branch_id!=null){
            $branch_id=$request->branch_id;

        }else{
            $branch_id='';
        }
        $paid_amount=$total_sale_amount[0]->total-$debt_amount[0]->total;

    return view('summary',compact('employees','invoice','branches','employees','origin_stock','start','end','emp_id','branch_id','paid_amount','total_sale_amount','debt_amount','cash_in_transit','total_sold','total_balance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
