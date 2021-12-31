<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MainCompany;
use App\Models\product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RequestForQuotation;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_orders=PurchaseOrder::with('vendor','tax','rfq')->get();
        return view('Purchase.PurchaseOrder.index',compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product=ProductVariations::with('product')->get();
        $suppliers = Customer::where('customer_type', 'Supplier')->get();
        $source=RequestForQuotation::all()->pluck('purchase_id','id')->all();
        $session_value = \Illuminate\Support\Str::random(10);
        $Auth = "PO-" . Auth::guard('employee')->user()->id;
        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $creation_id = Session::get($Auth);
        } else {
            $creation_id = Session::get($Auth);
        }
        $items=PurchaseOrderItem::where('creation_id', $creation_id)->get();
        $total = DB::table("purchase_order_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('creation_id', $creation_id)
            ->get();
        $grand_total = $total[0]->total;
        $po_data = Session::get('poformdata-' . Auth::guard('employee')->user()->id);
        $taxes=products_tax::all();
        $last_po = PurchaseOrder::orderBy('id', 'desc')->first();

        if ($last_po != null) {
            $last_po->purchaseorder_id++;
            $purchaseorder_id = $last_po->purchaseorder_id;
        } else {
            $purchaseorder_id = "PO-00001";
        }
        return view('Purchase.PurchaseOrder.create',compact('product','suppliers','source','creation_id','po_data','items','taxes','grand_total','purchaseorder_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'vendor_id'=>'required',
        'ordered_date'=>'required',
        'purchase_type'=>'required',
        ]);
        try {
            $po=PurchaseOrder::create($request->all());
            Session::forget('poformdata-' . Auth::guard('employee')->user()->id);
            $Auth = "PO-" . Auth::guard('employee')->user()->id;
            $creation_id = Session::get($Auth);
            $items=PurchaseOrderItem::where('creation_id',$creation_id)->get();
            foreach ($items as $item){
                $poitem=PurchaseOrderItem::where('id',$item->id)->first();
                $poitem->po_id=$po->id;
                $poitem->update();
            }
            Session::forget($Auth);
            return redirect('purchaseorders');
        }catch (Exception $e){

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po=PurchaseOrder::with('vendor','tax','rfq','employee')->where('id',$id)->firstOrFail();
        $items=PurchaseOrderItem::with('product')->where('po_id',$po->id)->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        $inventory_receipt=false;
        $products=product::all()->pluck('name','id')->all();
       return view('Purchase.PurchaseOrder.show',compact('po','items','company','inventory_receipt','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $po = PurchaseOrder::where('id', $id)->first();
        if ($po->confirm == 0) {
            $product = ProductVariations::with('product')->get();
            $suppliers = Customer::where('customer_type', 'Supplier')->get();
            $source = RequestForQuotation::all()->pluck('purchase_id', 'id')->all();
            $items = PurchaseOrderItem::where('po_id', $id)->get();
            $total = DB::table("purchase_order_items")
                ->select(DB::raw("SUM(total) as total"))
                ->where('po_id', $id)
                ->get();
            $grand_total = $total[0]->total;
//        dd($grand_total);
            $taxes = products_tax::all();

            return view('Purchase.PurchaseOrder.edit', compact('product', 'suppliers', 'source', 'items', 'taxes', 'grand_total', 'po'));
        }else{
            return redirect()->back()->with('warning','Does not edit now! Its have been confirmed.');
        }
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
        $po=PurchaseOrder::where('id',$id)->first();
        $po->vendor_id=$request->vendor_id;
        $po->rfq_id=$request->rfq_id;
        $po->ordered_date=$request->ordered_date;
        $po->deadline=$request->deadline;
        $po->purchase_type=$request->purchase_type;
        $po->vendor_reference=$request->vendor_reference;
        $po->subtotal=$request->subtotal;
        $po->discount=$request->discount;
        $po->tax_amount=$request->tax_amount;
        $po->tax_id=$request->tax_id;
        $po->grand_total=$request->grand_total;
        $po->update();
        return redirect(route('purchaseorders.show',$id));
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
    public function rfq_to_po_create($id){
        $rfq=RequestForQuotation::with('source', 'vendor')->where('id', $id)->firstOrFail();
        $rfq->status='Done';
        $rfq->update();
        $product=ProductVariations::with('product')->get();
        $suppliers = Customer::where('customer_type', 'Supplier')->get();
        $source=RequestForQuotation::all()->pluck('purchase_id','id')->all();
        $session_value = \Illuminate\Support\Str::random(10);
        $Auth = "PO-" . Auth::guard('employee')->user()->id;
        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $creation_id = Session::get($Auth);
        } else {
            $creation_id = Session::get($Auth);
        }
        $items=PurchaseOrderItem::where('creation_id', $creation_id)->get();
        $total = DB::table("purchase_order_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('creation_id', $creation_id)
            ->get();
        $grand_total = $total[0]->total;
        $po_data = Session::get('poformdata-' . Auth::guard('employee')->user()->id);
        $taxes=products_tax::all();
        $last_po = PurchaseOrder::orderBy('id', 'desc')->first();

        if ($last_po != null) {
            $last_po->purchaseorder_id++;
            $purchaseorder_id = $last_po->purchaseorder_id;
        } else {
            $purchaseorder_id = "PO-00001";
        }
        return view('Purchase.PurchaseOrder.create',compact('rfq','product','suppliers','source','creation_id','po_data','items','taxes','purchaseorder_id','grand_total'));
    }
    public function receive($id){
        $last_rfq =ProductReceive::orderBy('id', 'desc')->first();

        if ($last_rfq != null) {
            $last_rfq->purchase_id++;
            $received_id = $last_rfq->received_id;
        } else {
            $received_id = "WH/IN/"."00001";
        }
        $po=PurchaseOrder::where('id',$id)->first();
        $rfq_items = PurchaseOrderItem::with('product')->where('rfq_id', $id)->get();
        $product_receive=new ProductReceive();
        $product_receive->received_id=$received_id;
        $product_receive->schedule_date=Carbon::now();
        $product_receive->deadline=$po->deadline;
        $product_receive->po=$po->id;
        $product_receive->vendor_id=$po->vendor_id;
        $product_receive->save();
        foreach ($rfq_items as $item){
            $rece_item=new ProductReceiveItem();
            $rece_item->product_id=$item->product_id;
            $rece_item->demand=$item->qty;
            $rece_item->qty=$item->qty;
            $rece_item->po_id=$po->id;
            $rece_item->receipt_id=$product_receive->id;
            $rece_item->save();
        }

    }
    public function confirm($id){
        $po=PurchaseOrder::where('id',$id)->first();
        $po->confirm=1;
        $po->confirm_date=Carbon::now();
        $po->update();
        $already_exist=ProductReceive::where('po_id',$id)->first();
      if($already_exist==null)
      {
          $last_pr = ProductReceive::orderBy('id', 'desc')->first();

          if ($last_pr != null) {
              $last_pr->purchaseorder_id++;
              $received_id = $last_pr->received_id;
          } else {
              $received_id='WH/IN-0001';
          }
          $product_receive=new ProductReceive();
          $product_receive->vendor_id=$po->vendor_id;
          $product_receive->received_id=$received_id;
          $product_receive->receive_date=Carbon::now();
          $product_receive->po_id=$po->id;
          $product_receive->emp_id=Auth::guard('employee')->user()->id;
          $product_receive->save();
          $items=PurchaseOrderItem::where('po_id',$id)->get();
          foreach ($items as $item){
              $recipt_item=new ProductReceiveItem();
              $recipt_item->variant_id=$item->variant_id;
              $recipt_item->demand=$item->qty;
              $recipt_item->po_id=$po->id;
              $recipt_item->receipt_id=$product_receive->id;
              $recipt_item->price=$item->price;
              $recipt_item->save();
          }
          return redirect(route('purchaseorders.show',$id));
      }
    }
}
