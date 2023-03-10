<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\MainCompany;
use App\Models\po_follower;
use App\Models\product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\RequestForQuotation;
use App\Models\SellingUnit;
use App\Traits\Emailtrait;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PurchaseOrderController extends Controller
{
   use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Super Admin'){
            $purchase_orders=PurchaseOrder::orderby('id','desc')->with('vendor','tax','pr','employee','approver_name')->get();
        }else{
            $purchase_orders=PurchaseOrder::orderby('id','desc')->with('vendor','tax','pr','employee','approver_name')->where('emp_id',Auth::guard('employee')->user()->id)->get();

        }
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
        $source=PurchaseRequest::all()->pluck('pr_id','id')->all();
        $units=SellingUnit::all();
        $session_value = \Illuminate\Support\Str::random(10);
        $Auth = "PO-" . Auth::guard('employee')->user()->id;

        if (!Session::has($Auth)) {
            Session::push("$Auth", $session_value);
            $creation_id = Session::get($Auth);
        } else {
            $creation_id = Session::get($Auth);
        }
        $items=PurchaseOrderItem::with('product_unit','product')->where('creation_id', $creation_id)->get();
        $total = DB::table("purchase_order_items")
            ->select(DB::raw("SUM(total) as total"))
            ->where('creation_id', $creation_id)
            ->get();
        $grand_total = $total[0]->total;
        $po_data = Session::get('poformdata-' . Auth::guard('employee')->user()->id);
        $taxes=products_tax::all();
        $last_po = PurchaseOrder::orderBy('id', 'desc')->first();

        if ($last_po != null) {
            $last_po->po_id++;
            $po_id = $last_po->po_id;
        } else {
            $po_id = "PO-00001";
        }
        $emps=Employee::all();
        return view('Purchase.PurchaseOrder.create',compact('product','suppliers','source','creation_id','po_data','items','taxes','grand_total','po_id','emps','units'));
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
            'approver_id'=>'required',
        ]);
        try {
            if (isset($request->attach)) {
                foreach ($request->file('attach') as $attach) {
                    $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
                    $attach->move(public_path() . '/attach_file', $input['filename']);
                    $name[]=$input['filename'];
                }
                $data['attach'] = json_encode($name);

            }
           $data['po_id']=$request->po_id;
            $data['approver']=$request->approver_id;
            $data['vendor_id']=$request->vendor_id;
            $data['ordered_date']=$request->ordered_date;
            $data['purchase_type']=$request->purchase_type;
            $data['pr_id']=$request->pr_id;
            $data['deadline']=$request->deadline;
            $data['vendor_reference']=$request->vendor_reference;
            $data['description']=$request->descripion;
            $data['subtotal']=$request->subtotal;
            $data['discount']=$request->discount;
            $data['tax_amount']=$request->tax_amount;
            $data['tax_id']=$request->tax_id;
            $data['grand_total']=$request->grand_total;
            $data['emp_id']=$request->emp_id;
            $data['shipping_address']=$request->ship_to;
            $data['payable_amount']=$request->grand_total;
            $data['status']='New';
            $data['additional_cost']=$request->additional_cost??0;
            $po=PurchaseOrder::create($data);
            if($request->tag!=null){
                foreach ($request->tag as $emp){
                    $this->addtag($emp,$po->id);
                    $this->addnotify($emp,'warning',' Added as a follower of '.$request->po_id,'purchaseorders/'.$po->id,Auth::guard('employee')->user()->id);
                }
            }
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
            $this->addnotify($request->approver_id,'warning','Request Purchase Order to you '.$request->po_id,'purchaseorders/'.$po->id,Auth::guard('employee')->user()->id);
            return redirect('purchaseorders');
        }catch (Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public function addtag($emp_id,$po_id){
        $data['po_id']=$po_id;
        $data['emp_id']=$emp_id;
        po_follower::create($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po=PurchaseOrder::with('vendor','tax','pr','employee','approver_name')->where('id',$id)->firstOrFail();
        $items=PurchaseOrderItem::with('product')->where('po_id',$po->id)->get();
        $company=MainCompany::where('ismaincompany',true)->first();
        $inventory_receipt=false;
        $products=product::all()->pluck('name','id')->all();
        $product_receive=ProductReceive::where('po_id',$id)->first();
        $followers=po_follower::with('emp')->where('po_id',$id)->get();
        $attach=json_decode($po->attach)??[];
       return view('Purchase.PurchaseOrder.show',compact('po','items','company','inventory_receipt','products','product_receive','followers','attach'));
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
            $units=SellingUnit::all();
            $employees=Employee::all();

            return view('Purchase.PurchaseOrder.edit', compact('product', 'suppliers', 'source', 'items', 'taxes', 'grand_total', 'po','units','employees'));
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
        $po->pr_id=$request->pr_id;
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
    public function confirm($id){

        $po=PurchaseOrder::where('id',$id)->first();
       if($po->approver==Auth::guard('employee')->user()->id){
           $po->confirm=1;
           $po->confirm_date=Carbon::now();
           $po->status='Confirmed';
           $po->update();
           $already_exist=ProductReceive::where('po_id',$id)->first();
           if($already_exist==null)
           {
               $last_pr = ProductReceive::orderBy('id', 'desc')->first();

               if ($last_pr != null) {
                   $last_pr->received_id++;
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
                   $recipt_item->unit=$item->unit;
                   $recipt_item->receipt_id=$product_receive->id;
                   $recipt_item->price=$item->price;
                   $recipt_item->save();
               }

           }
           return redirect(route('purchaseorders.show',$id));

       }else{
           return redirect(route('purchaseorders.show',$id))->with('error','Your not approver for this purchase order');
       }
    }
    public function send($id){
        $po=PurchaseOrder::with('vendor','tax','pr','employee')->where('id',$id)->first();
        return view('Purchase.PurchaseOrder.mail_prepare',compact('po'));
    }
    public function sending(Request $request){
        $po=PurchaseOrder::where('id',$request->po_id)->first();
        if($request->attach!=null){
            $file = $request->attach;
            $file_name = $file->getClientOriginalName();
            $request->attach->move(public_path() . '/attach_file/', $file_name);
        }
        $details = array(
            'email' => $request->email,
            'subject' => 'Order Mail',
            'cc' => $request->cc,
            'content'=>$request->body,
            'attach' =>$request->attach!=null?public_path() . '/attach_file/' . $file_name:null,
        );
        Mail::send('Purchase.PurchaseOrder.sendmail', $details, function ($message) use ($details) {
            $message->to($details['email']);
            $message->subject($details['subject']);
            if ($details['cc'] != null) {
                $message->cc($details['cc']);
            }
            if ($details['attach'] != '') {
                $message->attach($details['attach']);
            }

        });
        $po->sent=1;
        $po->update();
        return redirect()->back()->with('success','Mail sent');
    }
}
