<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeliveryComment;
use App\Models\DeliveryOrder;
use App\Models\DeliveryPay;
use App\Models\Invoice;
use App\Models\MainCompany;
use App\Models\OrderItem;
use App\Models\Warehouse;
use App\Traits\Emailtrait;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ShippmentController extends Controller
{
    use Emailtrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if(Auth::guard('customer')->check()){
            $deliveries=DeliveryOrder::with('invoice','courier','customer')->where('courier_id',Auth::guard('customer')->user()->id)->get();
            $new_deli=DeliveryOrder::with('employee')->where('courier_id',Auth::guard('customer')->user()->id)->where('seen',0)->get();
            return view('Inventory.Shippment.index',compact('deliveries','new_deli'));
        }else{
            $deliveries=DeliveryOrder::with('invoice','courier','customer')->get();
            $delivery_finish=DeliveryOrder::where('receipt',1)->count();
            $delivery_unfinish=DeliveryOrder::where('receipt',0)->where('status','!=','cancel')->count();
            $delivery_cancel=DeliveryOrder::where('status','cancel')->count();
            $total_bill = DB::table("delivery_pays")
                ->select(DB::raw("SUM(delivery_fee) as total"))
                ->get();
            $total_receivable = DB::table("delivery_pays")
                ->select(DB::raw("SUM(invoice_amount) as total"))
                ->get();
            return view('Inventory.Shippment.index',compact('deliveries','delivery_unfinish','delivery_finish','delivery_cancel','total_bill','total_receivable'));
        }

    }

    public function transaction(){
       if(Auth::guard('customer')->check()) {
           $deliveries = DeliveryPay::with('delivery','courier')->where('courier_id', Auth::guard('customer')->user()->id)->get();
       }else{
           $deliveries = DeliveryPay::with('delivery','courier')->get();
       }
        return view('Inventory.Shippment.deli_pay_transaction',compact('deliveries'));
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
        $invoices=Invoice::with('customer','warehouse')->get();
        $customer=Customer::all();
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
            'delivery_id'=>'required|unique:delivery_orders',
            'delivery_date'=>'required',
            'delivery_fee'=>'required',
            'warehouse_id'=>'required',
            'shipping_address'=>'required',
            'receiver_phone'=>'required',
            'delivery_type'=>'required'
        ]);
        $customer=Customer::where('id',$request->courier_id)->first();
//        dd($customer);
        $delivery=DeliveryOrder::where('invoice_id',$request->invoice_id)->where('status','cancel')->first();
        if($delivery==null){
           $deli=DeliveryOrder::create($request->all());
           $data['email']=$customer->email;
           $data['name']=$customer->name;
           $data['subject']='Delivery Assigned Notification';
           $data['content']=ucfirst(Auth::guard('employee')->user()->name).'has assigned to you'.$deli->delivery_id;
           $data['link']='deliveries.show';
           $data['id']=$deli->id;
           $this->emailnoti($data);
           return redirect(route('deliveries.index'));
       }else{
           return redirect(route('deliveries.index'))->with('error','This invoice has been deliveried!');
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
        $delivery=DeliveryOrder::with('invoice','courier','customer')->where('id',$id)->firstOrFail();
        $detail_inv=Invoice::with('customer','employee','tax','order')->where('id',$delivery->invoice_id)->firstOrFail();
        $company=MainCompany::where('ismaincompany',true)->first();
        $invoic_item=OrderItem::with('variant')->where("inv_id",$detail_inv->id)->get();
        $comments=DeliveryComment::with('emp','courier')->where('delivery_id',$id)->get();
        if(Auth::guard('customer')->check()){
            $delivery->seen=1;
            $delivery->update();
            $new_deli=DeliveryOrder::with('employee')->where('courier_id',Auth::guard('customer')->user()->id)->where('seen',0)->get();
        }else{
            $new_deli=[];
        }

//        dd($comments);
        return view('Inventory.Shippment.show',compact('delivery','detail_inv','company','invoic_item','comments','new_deli'));
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
        if($delivery->courier_id==Auth::guard('customer')->user()->id){
            if($state!='cancel'&&$state!='accept'){
                $details = [

                    'subject' => $company->name??''."Delivery Tracking Notification.",
                    'email' =>$delivery->customer->email,
                    'name' =>$delivery->customer->name,
                    'inv_id' =>$delivery->invoice->invoice_id,
                    'courier_name'=>$delivery->courier->name,
                    'uuid'=>$delivery->uuid,
                    'company' => $company->name??'',

                ];
                Mail::send('Inventory.Shippment.email', $details, function ($message) use ($details) {
                    $message->from('cincin.com@gmail.com',$details['company']);
                    $message->to($details['email']);
                    $message->subject($details['subject']);
                });
            }
            if($state=='Packing'&& $delivery->packing==0){
                $delivery->packing=1;
                $delivery->packing_time=Carbon::now();
                $delivery->current_state='Packing';
                $delivery->update();
                return redirect(route('deliveries.show',$id));
            }elseif ($state=='Delivery' && $delivery->on_way==0){
                $delivery->on_way=1;
                $delivery->onway_time=Carbon::now();
                $delivery->current_state='Delivery';
                $delivery->update();
                return redirect(route('deliveries.show',$id));
            }elseif ($state=='Done' && $delivery->receipt==0){
                $delivery->receipt=1;
                $delivery->receipt_time=Carbon::now();
                $delivery->current_state='Done';
                $delivery->update();
                return redirect(route('deliveries.show',$id));
            }elseif ($state=='cancel'){
                $delivery->status='cancel';
                $delivery->current_state='Cancel';
                $delivery->update();
                return redirect(route('deliveries.index'))->with('success','Canceled delivery');
            }elseif($state=='accept'&&$delivery->status!='cancel'){
                $delivery->status='accept';
                $delivery->current_state='Accept';
                $exist_pay=DeliveryPay::where('delivery_id',$delivery->id)->first();
                if($exist_pay==null){
                    $deli_data['delivery_id']=$delivery->id;
                    $deli_data['delivery_code']=$delivery->delivery_id;
                    if($delivery->invoice->include_delivery_fee){
                        $deli_data['delivery_fee']=$delivery->delivery_fee;
                        $deli_data['paid_delivery_fee']=0;
                    }else{
                        $deli_data['delivery_fee']=0.0;
                        $deli_data['paid_delivery_fee']=1;
                    }
                    if($delivery->delivery_type=='Cash On Delivery(COD)'){
                        $deli_data['invoice_amount']=$delivery->amount_to_request;
                        $deli_data['due_amount']=$delivery->amount_to_request;
                    }else{
                        $deli_data['invoice_amount']=$delivery->amount_to_request;
                        $deli_data['due_amount']=$delivery->amount_to_request;
                        $deli_data['receiver_invoice_amount']=1;
                    }
                    $deli_data['courier_id']=$delivery->courier_id;
                    DeliveryPay::create($deli_data);
                }
                $delivery->update();
                return redirect(route('deliveries.show',$id))->with('success','Accepted delivery assign');
            }else{
                return redirect(route('deliveries.index'));
            }
        }else{
            return redirect(route('deliveries.index'))->with('error','You can not change state!');
        }
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
        $company=MainCompany::where('ismaincompany',true)->first();
        return view('Inventory.Shippment.tracking',compact('delivery','company'));
    }
    public function receipt($id){
        $delivery=DeliveryOrder::where('id',$id)->first();
        $delivery->customer_receive_confirm=1;
        $delivery->update();
        return redirect('delivery/tracking/'.$delivery->uuid)->with('success','Product Receipt Confirmed!');
    }
}
