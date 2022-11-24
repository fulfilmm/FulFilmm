<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderCc;
use App\Models\OrderItem;
use App\Models\ProductVariations;
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
        $orders=Order::with('customer','items')->where('emp_id',Auth::guard('api')->user()->id)->get();
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
            $order->save();
            $order_item = $request->order_items;
            $foc=$request->foc_items??[];
            if(count($order_item)!=0){
                foreach ($order_item as $item){

                    $item['order_id']=$order->id;
                    $item['type']='invoice';
                    $this->item_store($item);

                }
            }
            if(count($foc)!=0){
                foreach ($foc as $item){
                    $item->invoice_id=$order->id;
                    $item->type='invoice';
                    $this->foc_add($item);
                }
            }
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
    public function item_store($request)
    {
//        return response($request);
        $variant = ProductVariations::where('id', $request['variant_id'])->first();
//        return response($variant);
        if ($request['type'] == 'invoice') {
            $sub_total=$request['qty']*$request['price'];
            $discount=($request['discount']/100)*$sub_total;
            $total=$sub_total-$discount;
            $items = new OrderItem();
            $items->description =$variant->description;
            $items->quantity =$request['qty'];
            $items->variant_id = $request['variant_id'];
            $items->sell_unit = $request['unit_id'];
            $items->unit_price =$request['price'] ?? 0;
            $items->total =$total ?? 0;
            $items->discount_promotion=$request['discount'];
            $items->creation_id =\Illuminate\Support\Str::random(10);
            $items->order_id = $request['order_id'] ?? null;
            $items->state = 1;
            $items->save();
        }

    }
    public function foc_add($request){
        $variant = ProductVariations::where('id', $request->variant_id)->first();
        $items = new OrderItem();
        $items->description = 'This is FOC item';
        $items->quantity = 1;
        $items->variant_id = $variant->id;
        $items->unit_price = 0;
        $items->sell_unit = $request->unit_id;
        $items->total = 0;
        $items->creation_id =\Illuminate\Support\Str::random(10);
        $items->inv_id = $request->invoice_id;
        $items->order_id = $request->order_id ?? null;
        $items->state = 1;
        $items->foc=true;
        $items->save();
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
