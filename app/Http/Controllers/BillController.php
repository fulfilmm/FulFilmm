<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\MainCompany;
use App\Models\PurchaseOrder;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills=Bill::with('supplier')->get();
        return view('transaction.Bill.index',compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($supplier_id)
    {
        $vendor =Customer::where('id',$supplier_id)->first();
//        dd($vendor);
        $Auth=Auth::guard('employee')->user()->name;
//        Session::forget('data-'.Auth::guard('employee')->user()->id);
        $data=Session::get('bill-'.Auth::guard('employee')->user()->id);
//        dd($data);
//        Session::forget($Auth);
        $session_value=\Illuminate\Support\Str::random(10);
        if(!Session::has($Auth)){
            Session::push("$Auth",$session_value);
            $request_id=Session::get($Auth);
        }else{
            $request_id=Session::get($Auth);
        }
//        $generate_id=Str::uuid();
        $items=BillItem::with('purchaseorder','delivery')->where('creation_id',$request_id)->get();
//        dd($orderline);
        $total = DB::table("bill_items")
            ->select(DB::raw("SUM(amount) as total"))
            ->where('creation_id', $request_id)
            ->get();
        $grand_total = $total[0]->total;
        $pos=PurchaseOrder::where('paid_bill',0)->where('vendor_id',$supplier_id)->get();
        $delivery=DeliveryOrder::where('paid_deli_fee',0)->where('courier_id',$supplier_id)->get();
        return view('transaction.Bill.create',compact('vendor','data','grand_total','request_id','items','pos','delivery'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $last_bill= Bill::orderBy('id', 'desc')->first();

        if ($last_bill != null) {
            $last_bill->bill_id++;
            $bill_id = $last_bill->bill_id;
        } else {
            $bill_id = "Bill-00001";
        }
        $bill = new Bill();
        $bill->title=$request->title;
        $bill->bill_id=$bill_id;
        $bill->vendor_id=$request->vendor_id;
        $bill->email=$request->vendor_email;
        $bill->billing_address=$request->billing_address;
        $bill->bill_date=$request->bill_date;
        $bill->due_date=$request->due_date;
        $bill->status='Draft';
        $bill->payment_method=$request->payment_method;
        $bill->other_information=$request->other_info;
        $bill->grand_total=$request->grand_total;
        $bill->due_amount=$request->grand_total;
        $bill->emp_id=Auth::guard('employee')->user()->id;
        $bill->save();
        $Auth=Auth::guard('employee')->user()->name;
        $creation_id = Session::get($Auth);
        $bill_items = BillItem::where('creation_id', $creation_id)->get();
        foreach ($bill_items as $item) {
            $item->bill_id = $bill->id;
            $item->update();
            if($item->type=="Purchase"){
                $po=PurchaseOrder::where('id',$item->po_id)->first();
                $po->paid_bill=1;
                $po->update();
            }elseif ($item->type=='Delivery'){
             $delivery=DeliveryOrder::where('id',$item->delivery_id)->first();
             $delivery->paid_deli_fee=1;
             $delivery->update();
            }

        }
        Session::forget($Auth);
        Session::forget('bill-'.Auth::guard('employee')->user()->id);
        return redirect(route('bills.show',$bill->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account=Account::where('enabled',1)->get();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $customer=Customer::where('customer_type','Supplier')->get();
        $data=['customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        $bill=Bill::with('supplier','employee')->where('id',$id)->firstOrFail();
        $bill_item=BillItem::with('purchaseorder','delivery')->where('bill_id',$bill->id)->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        return view('transaction.Bill.show',compact('bill','bill_item','company','data'));
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
    public function po_to_bill($po_id)
    {
//        dd($po_id);
        $po = PurchaseOrder::where('paid_bill', 0)->where('id', $po_id)->first();
        if ($po != null) {
            $vendor = Customer::where('id', $po->vendor_id)->first();
//        dd($vendor);
            $Auth = Auth::guard('employee')->user()->name;
//        Session::forget('data-'.Auth::guard('employee')->user()->id);
//        Session::forget($Auth);
            $session_value = \Illuminate\Support\Str::random(10);
            if (!Session::has($Auth)) {
                Session::push("$Auth", $session_value);
                $request_id = Session::get($Auth);
            } else {
                $request_id = Session::get($Auth);
            }
            $item_exist=BillItem::where('po_id',$po->id)->first();
           if($item_exist==null){
               $items = new BillItem();
               $items->po_id = $po->id;
               $items->amount = $po->grand_total;
               $items->type = 'Purchase';
               $items->creation_id = $request_id[0];
               $items->save();
           }
//        $generate_id=Str::uuid();
            $items = BillItem::with('purchaseorder', 'delivery')->where('creation_id', $request_id)->get();
//        dd($orderline);

            $total = DB::table("bill_items")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('creation_id', $request_id)
                ->get();

            $grand_total = $total[0]->total;
            $po_to_bill = true;

            $pos = PurchaseOrder::where('paid_bill', 0)->where('vendor_id', $po->vendor_id)->get();
            $delivery = DeliveryOrder::where('paid_deli_fee', 0)->where('courier_id', $po->vendor_id)->get();
            return view('transaction.Bill.create', compact('vendor', 'grand_total', 'request_id', 'items', 'po_to_bill', 'pos', 'delivery'));
        }else{
            return redirect()->back()->with('warning','Already Created Bill');
        }
    }
    public function deli_bill($deli_id)
    {
//        dd($po_id);
        $delivery = DeliveryOrder::where('paid_deli_fee', 0)->where('id', $deli_id)->first();
        if ($delivery != null) {
            $vendor = Customer::where('id', $delivery->courier_id)->first();
//        dd($vendor);
            $Auth = Auth::guard('employee')->user()->name;
//        Session::forget('data-'.Auth::guard('employee')->user()->id);
//        Session::forget($Auth);
            $session_value = \Illuminate\Support\Str::random(10);
            if (!Session::has($Auth)) {
                Session::push("$Auth", $session_value);
                $request_id = Session::get($Auth);
            } else {
                $request_id = Session::get($Auth);
            }
//        dd($delivery);
            $exist_item=BillItem::where('delivery_id',$deli_id)->first();
           if($exist_item==null){
               $items = new BillItem();
               $items->delivery_id = $deli_id;
               $items->amount = $delivery->delivery_fee;
               $items->type = 'Delivery';
               $items->creation_id = $request_id[0];
               $items->save();
           }

//        $generate_id=Str::uuid();
            $items = BillItem::with('purchaseorder', 'delivery')->where('creation_id', $request_id)->get();
//        dd($orderline);

            $total = DB::table("bill_items")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('creation_id', $request_id)
                ->get();

            $grand_total = $total[0]->total;
            return view('transaction.Bill.deliverybill', compact('vendor', 'grand_total', 'request_id', 'items', 'delivery'));
        }else{
            return redirect()->back()->with('warning','Already Created Bill');
        }
    }
}
