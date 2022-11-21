<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderCc;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::with('customer','items')->get();
        return response()->json(['result'=>$orders,'con'=>true]);
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
        $validator=Validator::make($request->all(),[
            'customer_id'=>'required',
            'grand_total'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'address'=>'required',
            'payment_method'=>'required',
            'payment_term'=>'required',
            'order_date'=>'required',
            'billing_address'=>'required',
        ]);
        $last_order=Order::orderBy('id', 'desc')->first();

        if ($last_order!=null) {
            // Sum 1 + last id
            $last_order->order_id++;
            $order_id = $last_order->order_id;
        } else {
            $order_id='ORD'."-0001";
        }
        if($validator->passes()) {
            $order = new Order();
            $order->order_id = $order_id;
            $order->customer_id = $request->customer_id;
            $order->grand_total = $request->grand_total;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->payment_method = $request->payment_method;
            $order->payment_term = $request->payment_term;
            $order->billing_address=$request->billing_address;
            $order->quotation_id=$request->quotation_id;
            $order->shipping_type=$request->shipping_type;
            $order->shipping_address=$request->shipping_address;
            $order->billing_address=$request->billing_address;
            $order->tax_id=$request->tax_id;
            $order->expected_arrival_date=$request->arrival_date;
            $order->approver_id=$request->approver_id;
            $order->tax_amount=$request->tax_amount??0;
            $order->total=$request->total??0;
            $order->discount=$request->discount??0;
            $order->status="New";
            $order->emp_id=Auth::guard('api')->user()->id??$request->approver_id;
            $order->order_date = Carbon::create($request->order_date);

            if(Auth::guard('employee')->check()){
                $Auth="order-".Auth::guard('employee')->user()->name;
            }else{
                $Auth= "order-" .Auth::guard('customer')->user()->name;
            }
            $request_id=Session::get($Auth);
//            dd($request_id);
            $confirm_order_item=OrderItem::where("creation_id",$request_id)->get();
            if(count($confirm_order_item)==0){
                return response()->json(['orderempty'=>'Order Item Empty']);
            }else{
                $order->save();
            }
//            dd($confirm_order_item);
            foreach ($confirm_order_item as $item){
                $item->order_id=$order->id;
                $item->update();
            }
            Session::forget($Auth);
//            dd($request->cc );
            if($request->cc!=null){
                foreach ($request->cc as $key=>$val){
                    $exists_cc=OrderCc::where('order_id',$order->id)->where('emp_id',$val)->first();
                    if($exists_cc==null){
                        $employee=Employee::where('id',$val)->first();
                        $cc=new OrderCc();
                        $cc->order_id=$order->id;
                        $cc->emp_id=$val;
                        $cc->emp_name=$employee->name;
                        $cc->save();
                    }
                }
            }
            return response()->json(['con'=>true,'msg' => 'Order Create Success']);
        }else{
            return response()->json(['con'=>true,'msg'=>$validator->errors()]);
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
