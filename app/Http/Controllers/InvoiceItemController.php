<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
//        dd($request->all());

        $invoice_data=['title'=>$request->title, "client_id"=>$request->client_id,
            'client_email'=>$request->client_email,
            'inv_date'=>$request->inv_date,
            "due_date"=>$request->due_date,
            'client_address'=>$request->client_address,
            "more_info"=>$request->more_info,
            'bill_address'=>$request->bill_address,
            'status'=>$request->status,
            'order_id'=>$request->order_id,
            'payment_method'=>$request->payment];
        $Auth=Auth::guard('employee')->user()->id;
        if(!Session::has($Auth)){
            Session::push("data-".$Auth,$invoice_data);
        }
        $product=product::with('taxes')->where('id',$request->product_id)->first();
        $items=new OrderItem();
        $items->product_id=$request->product_id;
        $items->description=$product->description;
        $items->quantity=1;
        $items->tax_id=$product->taxes->rate;
        $items->discount=0;
        $items->discount_type='%';
        $items->unit_price=$product->sale_price;
        $items->currency_unit=$product->currency_unit;
        $items->total=$product->sale_price;
        $items->creation_id=$request->invoice_id;
        $items->state=1;
        $items->save();
        return response()->json([
            'Message'=>'Success'
        ]);
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
//        dd($request->all());
        $items=OrderItem::where('id',$id)->first();
        $items->product_id=$request->product_id;
        $items->description=$request->description;
        $items->quantity=$request->quantity;
        $items->tax_id=$request->tax_id;
        $items->unit_price=$request->unit_price;
        $items->currency_unit=$request->currency_unit;
        $items->total=$request->total;
        $items->update();
        return response()->json([
            'Message'=>'Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice_item=OrderItem::where('id',$id)->first();
        $invoice_item->delete();
        return response()->json(['Delete'=>"Delete Success"]);
    }
}
