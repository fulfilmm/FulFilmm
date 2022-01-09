<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeliveryComment;
use App\Models\DeliveryOrder;
use App\Models\Invoice;
use App\Models\MainCompany;
use App\Models\OrderItem;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ShippmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $deliveries=DeliveryOrder::with('invoice','courier','customer')->get();
        return view('Inventory.Shippment.index',compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_deli = DeliveryOrder::orderBy('id', 'desc')->first();

        if ($last_deli != null) {
            $last_deli->delivery_id++;
            $delivery_id = $last_deli->delivery_id;
        } else {
            $delivery_id = "D-00001";
        }
        $invoices=Invoice::all();
        $customer=Customer::where('status','Qualified')->get();
        $courier=Customer::where('customer_type','Courier')->get();
        $warehouse=Warehouse::all()->pluck('name','id')->all();
        return view('Inventory.Shippment.create',compact('invoices','customer','courier','warehouse','delivery_id'));
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
        $this->validate($request,[
            'courier_id'=>'required',
            'invoice_id'=>'required',
            'customer_id'=>'required',
            'delivery_id'=>'required',
            'delivery_date'=>'required',
            'delivery_fee'=>'required',
            'warehouse_id'=>'required',
            'shipping_address'=>'required'
        ]);
        DeliveryOrder::create($request->all());
        return redirect(route('deliveries.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery=DeliveryOrder::with('invoice','courier','customer')->where('id',$id)->firstOrFail();
        $detail_inv=Invoice::with('customer','employee','tax','order')->where('id',$delivery->invoice_id)->firstOrFail();
        $company=MainCompany::where('ismaincompany',true)->first();
        $invoic_item=OrderItem::with('product')->where("inv_id",$detail_inv->id)->get();
        $comments=DeliveryComment::with('emp','courier')->where('delivery_id',$id)->get();
//        dd($comments);
        return view('Inventory.Shippment.show',compact('delivery','detail_inv','company','invoic_item','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $delivery=DeliveryOrder::with('customer','courier','invoice','warehouse')->where('id',$id)->firstOrFail();
        $invoices=Invoice::all();
        $customer=Customer::where('status','Qualified')->get();
        $courier=Customer::where('customer_type','Courier')->get();
        $warehouse=Warehouse::all()->pluck('name','id')->all();
        return view('Inventory.Shippment.edit',compact('invoices','customer','courier','warehouse','delivery'));
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
        $delivery=DeliveryOrder::where('id',$id)->first();
       if(Auth::guard('employee')->check())
       {
           $delivery->courier_id=$request->courier_id;
           $delivery->invoice_id=$request->invoice_id;
           $delivery->customer_id=$request->customer_id;
           $delivery->delivery_date=$request->delivery_date;
           $delivery->delivery_fee=$request->delivery_fee;
           $delivery->warehouse_id=$request->warehouse_id;
           $delivery->shipping_address=$request->shipping_address;
       }
        $delivery->reach_date=$request->reach_date;
        $delivery->estimate_date=$request->estimate_date;
        $delivery->update();
        return redirect(route('deliveries.index'));
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
    public function statuschange($state,$id){
        $delivery=DeliveryOrder::with('invoice','customer','courier')->where('id',$id)->first();
        if($state=='Packing'&& $delivery->packing==0){
            $delivery->packing=1;
            $delivery->packing_time=Carbon::now();
        }elseif ($state=='Delivery' && $delivery->on_way==0){
            $delivery->on_way=1;
            $delivery->onway_time=Carbon::now();
        }elseif ($state=='Done' && $delivery->receipt==0){
            $delivery->receipt=1;
            $delivery->receipt_time=Carbon::now();
        }
        $details = [

            'subject' => $company->name??''."Delivery Tracking Notification.",
            'email' =>$delivery->customer->email,
            'name' =>$delivery->customer->name,
            'inv_id' =>$delivery->invoice->invoice_id,
            'courier_name'=>$delivery->courier->name,
            'uuid'=>$delivery->uuid,
            'from' => Auth::guard('employee')->user()->email,
            'from_name' => Auth::guard('employee')->user()->name,
            'company' => $company->name??'',

        ];
        Mail::send('Inventory.Shippment.email', $details, function ($message) use ($details) {
            $message->from($details['from'], $details['company']);
            $message->to($details['email']);
            $message->subject($details['subject']);
        });
        $delivery->update();
    }
    public function comment(Request $request){
       $comment=new DeliveryComment();
        $comment->delivery_id=$request->delivery_id;
        $comment->comment=$request->comments;
        $comment->emp_id=Auth::guard('employee')->user()->id??null;
        $comment->courier_id=Auth::guard('customer')->user()->id??null;
        $comment->save();
        return redirect()->back();
    }
    public function tracking($uuid){
        $delivery=DeliveryOrder::with('invoice','courier','customer')->where('uuid',$uuid)->firstOrFail();
        return view('Inventory.Shippment.tracking',compact('delivery'));
    }
}
